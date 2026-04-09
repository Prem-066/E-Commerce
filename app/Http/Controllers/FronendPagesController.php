<?php

namespace App\Http\Controllers;

use App\Jobs\SendContactMailJob;
use App\Jobs\SendOrderEmailJob;
use App\Livewire\SuperAdmin\LoyalitySettings;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\loyaltyhistories;
use App\Models\LoyaltyHistory;
use App\Models\LoyaltySetting;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Settings;
use App\Models\store;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Str;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FronendPagesController extends Controller
{
    public function index()
    {
        $userCity = session('user_city');

        $baseQuery = Product::where('is_active', true);

        if ($userCity) {
            $baseQuery->whereHas('store', function ($q) use ($userCity) {
                $q->whereRaw('LOWER(trim(city)) = ?', [strtolower(trim($userCity))]);
            });
        }
        $products = (clone $baseQuery)->latest()->take(8)->get();
        $bannerProducts = (clone $baseQuery)->inRandomOrder()->take(3)->get();
        $exclusiveProducts = (clone $baseQuery)->inRandomOrder()->take(2)->get();
        $brands = Brand::where('is_active', true)
            ->whereHas('products.store', function ($q) use ($userCity) {
                if ($userCity) {
                    $q->whereRaw('LOWER(trim(city)) = ?', [strtolower(trim($userCity))]);
                }
            })
            ->get();

        $categories = Category::where('is_active', true)
            ->whereHas('products', function ($query) use ($userCity) {
                if ($userCity) {
                    $query->whereHas('store', function ($q) use ($userCity) {
                        $q->whereRaw('LOWER(trim(city)) = ?', [strtolower(trim($userCity))]);
                    });
                }
                $query->inRandomOrder();
            })
            ->with(['products' => function ($query) use ($userCity) {
                if ($userCity) {
                    $query->whereHas('store', function ($q) use ($userCity) {
                        $q->whereRaw('LOWER(trim(city)) = ?', [strtolower(trim($userCity))]);
                    });
                }
                $query->inRandomOrder();
            }])
            ->take(5)
            ->get();

        $deals = (clone $baseQuery)->latest()->take(9)->get();

        return view('fronend.pages.hero-home', compact('products', 'bannerProducts', 'exclusiveProducts', 'brands', 'categories', 'deals'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $userCity = session('user_city');

        $productsQuery = Product::where('is_active', 1);

        if ($userCity) {
            $productsQuery->whereHas('store', function ($q) use ($userCity) {
                $q->whereRaw('LOWER(trim(city)) = ?', [strtolower(trim($userCity))]);
            });
        }

        if ($query) {
            $productsQuery->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('sku', 'LIKE', "%{$query}%")
                    ->orWhere('sort_description', 'LIKE', "%{$query}%");
            });
        }

        $products = $productsQuery->paginate(12);

        if ($request->ajax()) {
            return response()->json($products);
        }

        return view('fronend.pages.shop', compact('products', 'query'));
    }
    public function productDetail($slug)
    {
        $productDetail = Product::where('slug', $slug)->firstOrFail();
        $productImg = ProductImage::where('product_id', $productDetail->id)->get();

        $userCity = session('user_city');

        $relatedQuery = Product::where('category_id', $productDetail->category_id)
            ->where('id', '!=', $productDetail->id)
            ->where('is_active', true);

        if ($userCity) {
            $relatedQuery->whereHas('store', function ($q) use ($userCity) {
                $q->whereRaw('LOWER(trim(city)) = ?', [strtolower(trim($userCity))]);
            });
        }

        $relatedProducts = $relatedQuery->limit(9)->get();
        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Product::where('category_id', $productDetail->category_id)
                ->where('id', '!=', $productDetail->id)
                ->limit(9)
                ->get();
        }

        return view('fronend.pages.product-detail', compact('productDetail', 'productImg', 'relatedProducts'));
    }

    public function addToCart($slug)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'login_required', 'url' => route('login-front')], 401);
        }

        $customer = Customer::where('user_id', Auth::id())->first();
        if (!$customer) {
            return response()->json(['status' => 'error', 'message' => 'Please register first'], 400);
        }

        $product = Product::where('slug', $slug)->firstOrFail();

        $cartItem = Cart::where('customer_id', $customer->id)->where('product_id', $product->id)->first();
        $currentCartQty = $cartItem ? $cartItem->quantity : 0;

        if (($currentCartQty + 1) > $product->stock) {
            return response()->json([
                'status' => 'error',
                'message' => 'Only ' . $product->stock . ' items available in stock. You already have ' . $currentCartQty . ' in cart.'
            ], 400);
        }

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'customer_id' => $customer->id,
                'product_id'  => $product->id,
                'quantity'    => 1
            ]);
        }

        $totalCount = Cart::where('customer_id', $customer->id)->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart!',
            'cart_count' => $totalCount
        ]);
    }

    public function showCart()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        if (!$customer) {
            return redirect()->route('login-front');
        }
        $allCartItems = Cart::where('customer_id', $customer->id)->with('product')->get();

        $stockErrors = false;
        foreach ($allCartItems as $item) {
            if (!$item->product || $item->product->stock < $item->quantity) {
                $stockErrors = true;
                break;
            }
        }

        return view('fronend.pages.procut-cart', compact('allCartItems', 'stockErrors'));
    }

    public function updateCart(Request $request)
    {
        $cartItem = Cart::find($request->cart_id);
        if (!$cartItem) return response()->json(['status' => 'error', 'message' => 'Item not found']);

        $newQty = $request->quantity;
        if ($newQty > $cartItem->product->stock) {
            return response()->json(['status' => 'error', 'message' => 'Only ' . $cartItem->product->stock . ' items in stock', 'current_qty' => $cartItem->quantity]);
        }

        $cartItem->quantity = $newQty;
        $cartItem->save();

        $allItems = Cart::where('customer_id', $cartItem->customer_id)->get();

        $totalSellingPrice = 0;
        $totalOriginalPrice = 0;
        $totalDeliveryCharge = 0;

        foreach ($allItems as $item) {
            $sellingPrice = $item->product->price;
            $originalPrice = ($item->product->discount_price > $sellingPrice) ? $item->product->discount_price : ($sellingPrice / 0.6);

            $totalSellingPrice += ($sellingPrice * $item->quantity);
            $totalOriginalPrice += ($originalPrice * $item->quantity);
            $totalDeliveryCharge += ($item->product->delivery_charge ?? 0);
        }

        $couponRemoved = false;
        if (session()->has('coupon')) {
            $couponData = session()->get('coupon');

            $minRequired = $couponData['min_amount'] ?? 120000;

            if ($totalSellingPrice < $minRequired) {
                session()->forget('coupon');
                $couponRemoved = true;
            }
        }

        $couponDiscount = session('coupon') ? session('coupon')['discount'] : 0;
        $productDiscount = $totalOriginalPrice - $totalSellingPrice;
        $finalBill = $totalSellingPrice + $totalDeliveryCharge - $couponDiscount;

        $stockErrors = false;
        foreach ($allItems as $item) {
            if (!$item->product || $item->product->stock < $item->quantity) {
                $stockErrors = true;
                break;
            }
        }

        return response()->json([
            'status' => 'success',
            'new_qty' => $cartItem->quantity,
            'item_subtotal' => number_format($cartItem->product->price * $cartItem->quantity),
            'total_original' => number_format($totalOriginalPrice),
            'product_discount' => number_format($productDiscount),
            'product_selling_total' => number_format($totalSellingPrice),
            'total_delivery_charge' => number_format($totalDeliveryCharge),
            'final_bill' => number_format($finalBill),
            'has_stock' => ($cartItem->product->stock > $cartItem->quantity),
            'stock_errors' => $stockErrors,
            'total_cart_count' => $allItems->count(),
            'coupon_removed' => $couponRemoved
        ]);
    }

    public function checkCartStock()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Please login to continue.']);
        }

        $allCartItems = Cart::where('customer_id', $customer->id)->with('product')->get();
        if ($allCartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.']);
        }

        foreach ($allCartItems as $item) {
            if (!$item->product || $item->product->stock < $item->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Item '{$item->product->name}' is out of stock or has insufficient quantity. Please refresh your cart page."
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function removeFromCart(Request $request)
    {
        $cartItem = Cart::find($request->cart_id);

        if ($cartItem) {
            $cartItem::where('id', $request->cart_id)->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function userProfile()
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();

        if ($customer) {
            $loyaltyHistory = DB::table('loyalty_histories')
                ->leftJoin('orders', 'loyalty_histories.order_id', '=', 'orders.id')
                ->leftJoin('order_items', 'loyalty_histories.order_item_id', '=', 'order_items.id')
                ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
                ->where('loyalty_histories.customer_id', $customer->id)
                ->select(
                    'orders.id as order_id',
                    'orders.order_number',
                    'orders.total_amount',
                    'products.name as product_name',
                    'products.image as product_image',
                    'products.return_policy_days',
                    'order_items.delivered_at',
                    'loyalty_histories.created_at',
                    'loyalty_histories.points',
                    'loyalty_histories.type',
                    'loyalty_histories.status'
                )
                ->orderBy('loyalty_histories.created_at', 'desc')
                ->paginate(5);

            $pointsSummary = DB::table('loyalty_histories')
                ->where('customer_id', $customer->id)
                ->select(
                    DB::raw("SUM(CASE WHEN (status = 'completed') AND type = 'earned' THEN points ELSE 0 END) as confirmed_earned"),
                    DB::raw("SUM(CASE WHEN status = 'pending' AND type = 'earned' THEN points ELSE 0 END) as pending_earned"),
                    DB::raw("SUM(CASE WHEN type = 'redeemed' THEN points ELSE 0 END) as total_redeemed")
                )
                ->first();
        } else {
            $loyaltyHistory = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 5);
            $pointsSummary = (object)[
                'confirmed_earned' => 0,
                'pending_earned' => 0,
                'total_redeemed' => 0
            ];
        }

        $settings = LoyaltySetting::first();
        $pointValue = $settings ? $settings->point_value_in_currency : 1;

        $ordersCount = $customer ? Order::where('customer_id', $customer->id)->count() : 0;
        $cartCount = $customer ? Cart::where('customer_id', $customer->id)->count() : 0;

        return view('fronend.partials.pages.profile', compact('user', 'customer', 'loyaltyHistory', 'pointValue', 'settings', 'ordersCount', 'cartCount', 'pointsSummary'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        $customer = Customer::where('user_id', $user->id)->first();

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('customers', 'public');
        } else {
            $imagePath = $customer->profile_image ?? null;
        }
        Customer::updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'office_address' => $request->office_address,
                'selected_add' => $request->selected_add,
                'profile_image' => $imagePath,
            ]
        );

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function buyNow($slug)
    {
        if (!Auth::check()) {

            return redirect()->route('login-front');
        }
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Product is currently out of stock.');
        }

        $customer = Customer::where('user_id', auth()->id())->first();
        $settings = LoyaltySetting::first();

        $pointValue = $settings ? $settings->point_value_in_currency : 1;

        $grandTotal = $product->price;
        $availablePoints = 0;

        if ($customer) {
            $availablePoints = $customer->loyalty_points ?? 0;
        }

        return view('fronend.pages.buy-now', compact(
            'product',
            'customer',
            'availablePoints',
            'pointValue',
            'grandTotal'
        ));
    }

    public function checkout()
    {
        $customer = Customer::where('user_id', auth()->id())->first();
        $allCartItems = Cart::where('customer_id', $customer->id)->with('product')->get();

        if ($allCartItems->isEmpty()) {
            return redirect()->route('trend-era-shop')->with('error', 'Your cart is empty.');
        }

        foreach ($allCartItems as $item) {
            if (!$item->product || $item->product->stock < $item->quantity) {
                return redirect()->route('cart.show')->with('error', 'Some items in your cart are out of stock or have insufficient quantity. Please update your cart.');
            }
        }

        $totalSellingPrice = 0;
        $totalDeliveryCharge = 0;
        foreach ($allCartItems as $item) {
            if ($item->product) {
                $totalSellingPrice += $item->product->price * $item->quantity;
                $totalDeliveryCharge += $item->product->delivery_charge ?? 0;
            }
        }
        $grandTotal = $totalSellingPrice + $totalDeliveryCharge;

        $settings = LoyaltySetting::first();
        $pointValue = $settings->point_value_in_currency;
        $availablePoints = $customer->loyalty_points ?? 0;
        return view(
            'fronend.pages.checkout',
            compact('allCartItems', 'totalSellingPrice', 'totalDeliveryCharge', 'grandTotal', 'customer', 'availablePoints', 'pointValue', 'settings')
        );
    }

    public function wishlist()
    {
        if (!Auth::check()) {
            return redirect()->route('login-front');
        }

        $customer = Customer::where('user_id', Auth::id())->first();

        if ($customer) {
            $wishlistItems = Wishlist::where('customer_id', $customer->id)
                ->with(['product' => function ($q) {
                    $q->select('id', 'name', 'price', 'slug', 'image', 'stock', 'description');
                }])
                ->get();
        } else {
            $wishlistItems = [];
        }

        return view('fronend.partials.pages.wishlist', compact('wishlistItems'));
    }

    public function addToWishlist($product_id)
    {
        if (!Auth::check()) {
            return redirect()->route('login-front')->with('error', 'Please login first');
        }

        $customer = Customer::where('user_id', Auth::id())->first();

        if (!$customer) {
            return back()->with('error', 'Customer profile not found.');
        }

        $exists = Wishlist::where('customer_id', $customer->id)
            ->where('product_id', $product_id)
            ->first();

        if (!$exists) {
            Wishlist::create([
                'customer_id' => $customer->id,
                'product_id'  => $product_id
            ]);
            return back()->with('success', 'Product added to wishlist!');
        }

        return back()->with('info', 'Already in your wishlist!');
    }

    public function removeFromWishlist($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login-front');
        }

        $customer = Customer::where('user_id', Auth::id())->first();

        if (!$customer) {
            return back()->with('error', 'Customer not found');
        }

        $wishlist = Wishlist::where('customer_id', $customer->id)
            ->where('id', $id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Item removed from wishlist');
        }

        return back()->with('error', 'Item not found');
    }

    public function contact()
    {
        $settings = Settings::first();
        return view('fronend.pages.contact', compact('settings'));
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $data = $request->only(['name', 'email', 'subject', 'message']);

        SendContactMailJob::dispatch($data);

        return back()->with('success', 'Message sent successfully!');
    }

    public function placeOrder(Request $request)
    {
        $grandTotal = $request->total_amount;
        if ($request->payment_method === 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            try {
                $charge = Charge::create([
                    "amount" => $grandTotal * 100,
                    "currency" => "inr",
                    "source" => $request->stripeToken,
                    "description" => "Order Payment from " . auth()->user()->email,
                ]);

                return $this->saveOrder($request, 'paid');
            } catch (\Exception $e) {
                return back()->withErrors('Payment failed! ' . $e->getMessage());
            }
        } else {
            return $this->saveOrder($request, 'pending');
        }
    }

    public function saveOrder(Request $request, $paymentStatus)
    {

        $customer = Customer::where('user_id', auth()->id())->first();

        $userCity = session('user_city');

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'number' => 'required|digits:10',
            'email' => 'required|email',
            'add1' => 'required',
            'city' => 'required',
            'zip' => 'required|digits:6',
            'payment_method' => 'required',
            'total_amount' => 'required|numeric'
        ]);

        DB::beginTransaction();
        try {
            $storeId = null;
            if ($userCity) {
                $currentStore = Store::whereRaw('LOWER(trim(city)) = ?', [strtolower(trim($userCity))])->first();
                if ($currentStore) {
                    $storeId = $currentStore->id;
                }
            }
            if (!$storeId) {
                if ($request->has('buy_now') && $request->product_id) {
                    $p = Product::find($request->product_id);
                    $storeId = $p ? $p->store_id : null;
                } else {
                    $firstCartItem = Cart::where('customer_id', $customer->id)->first();
                    if ($firstCartItem && $firstCartItem->product) {
                        $storeId = $firstCartItem->product->store_id;
                    }
                }
            }

            $order = new Order();
            $order->admin_id = 1;
            $order->store_id = $storeId;
            $order->customer_id = $customer->id;
            $order->order_number = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(8));
            $order->customer_name = $request->first_name;
            $order->customer_last_name = $request->last_name;
            $order->customer_email = $request->email;
            $order->customer_phone = $request->number;
            $order->address = $request->add1;
            $order->city = $request->city;
            $order->zip_code = $request->zip;
            $order->payment_method = $request->payment_method;
            $order->payment_status = $paymentStatus;
            $order->order_type = 'Online';
            $order->order_status = 'Pending';
            $order->total_amount = $request->total_amount;
            $order->coupon_discount = $request->coupon_discount;
            $order->coupon_code = $request->coupon_code;
            $order->order_notes = $request->message;
            $order->save();

            $pointsRedeemed = (int) $request->points_redeemed;
            if ($pointsRedeemed > 0 && $customer->loyalty_points >= $pointsRedeemed) {

                $customer->decrement('loyalty_points', $pointsRedeemed);

                LoyaltyHistory::create([
                    'customer_id' => $customer->id,
                    'order_id'    => $order->id,
                    'points'      => $pointsRedeemed,
                    'type'        => 'redeemed',
                    'description' => "Redeemed $pointsRedeemed points on Order #{$order->order_number}"
                ]);
            }


            $loyalty = LoyaltySetting::where('enable_loyalty', 1)->first();

            $pointsEarnedTotal = 0;
            $emailCart = [];

            if ($request->has('buy_now') && $request->buy_now == 1 && $request->product_id) {

                $product = Product::find($request->product_id);
                if ($product) {
                    $qty = 1;

                    if ($product->stock < $qty) {
                        throw new \Exception("Product '{$product->name}' is out of stock.");
                    }

                    $emailCart[$product->id] = [
                        'name'  => $product->name,
                        'qty'   => $qty,
                        'price' => $product->price,
                    ];

                    $orderItem = OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'qty' => $qty,
                        'price' => $product->price,
                    ]);

                    if ($loyalty) {
                        $pointsEarned = floor(($product->price * $qty) / 100) * $loyalty->points_per_hundred;
                        if ($pointsEarned > 0) {
                            $pointsEarnedTotal += $pointsEarned;
                            LoyaltyHistory::create([
                                'customer_id'   => $customer->id,
                                'order_id'      => $order->id,
                                'order_item_id' => $orderItem->id,
                                'points'        => $pointsEarned,
                                'type'          => 'earned',
                                'status'        => 'pending',
                                'description'   => "Earned $pointsEarned points from {$product->name}"
                            ]);
                        }
                    }

                    $product->decrement('stock', $qty);
                }
            } else {

                $cartItems = Cart::where('customer_id', $customer->id)->with('product')->get();

                foreach ($cartItems as $item) {
                    if (!$item->product || $item->product->stock < $item->quantity) {
                        throw new \Exception("Item '{$item->product->name}' has insufficient stock. Please go back to cart and update.");
                    }

                    if ($item->product) {
                        $emailCart[$item->product_id] = [
                            'name'  => $item->product->name,
                            'qty'   => $item->quantity,
                            'price' => $item->product->price,
                        ];

                        $orderItem = OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $item->product_id,
                            'qty' => $item->quantity,
                            'price' => $item->product->price,
                        ]);



                        if ($loyalty) {
                            $pointsEarned = floor(($item->product->price * $item->quantity) / 100) * $loyalty->points_per_hundred;
                            if ($pointsEarned > 0) {
                                $pointsEarnedTotal += $pointsEarned;
                                LoyaltyHistory::create([
                                    'customer_id'   => $customer->id,
                                    'order_id'      => $order->id,
                                    'order_item_id' => $orderItem->id,
                                    'points'        => $pointsEarned,
                                    'type'          => 'earned',
                                    'status'        => 'pending',
                                    'description'   => "Earned $pointsEarned points from {$item->product->name}"
                                ]);
                            }
                        }

                        $item->product->decrement('stock', $item->quantity);
                    }
                }
                $couponSession = session('coupon');
                if ($couponSession) {
                    $c = Coupon::find($couponSession['id']);
                    if ($c && $c->usage_limit !== null) {
                        $c->decrement('usage_limit');
                    }
                }

                Cart::where('customer_id', $customer->id)->delete();
                session()->forget('coupon');
            }

            if ($order->customer_email) {
                SendOrderEmailJob::dispatch(
                    $order->id,
                    $emailCart,
                    $order->customer_email,
                    $pointsRedeemed,
                    $pointsEarnedTotal
                );
            }

            DB::commit();
            return redirect()->route('order.success')->with([
                'success' => 'Order placed successfully!',
                'order_number' => $order->order_number
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function history()
    {
        $customer = Customer::where('user_id', auth()->id())->first();

        if ($customer) {
            $orders = Order::where('customer_id', $customer->id)
                ->orderBy('created_at', 'desc')
                ->get();
            foreach ($orders as $order) {
                $order->items = DB::table('order_items')
                    ->join('products', 'order_items.product_id', '=', 'products.id')
                    ->where('order_items.order_id', $order->id)
                    ->select('order_items.id', 'products.name', 'products.return_policy_days', 'products.image', 'order_items.qty', 'order_items.price', 'order_items.status', 'order_items.delivered_at')
                    ->get();

                $order->redeemed_details = DB::table('loyalty_histories')
                    ->where('order_id', $order->id)
                    ->where('type', 'redeemed')
                    ->first();
            }
        } else {
            $orders = [];
        }

        return view('fronend.partials.pages.order-history', compact('orders'));
    }



    public function downloadInvoice($id)
    {
        $order = Order::findOrFail($id);

        $order->items = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('order_items.order_id', $order->id)
            ->select(
                'order_items.id',
                'products.name',
                'products.image',
                'order_items.qty',
                'order_items.price',
                'order_items.status',
                'order_items.delivered_at'
            )
            ->get();

        $order->redeemed_details = DB::table('loyalty_histories')
            ->where('order_id', $order->id)
            ->where('type', 'redeemed')
            ->first();

        $logo = DB::table('orders')->where('id',$id)->first();
        $setting=DB::table('store_settings')->where('store_id',$logo->store_id)->first();

        $pdf = Pdf::loadView('fronend.partials.pages.invoice', compact('order', 'setting'));

        return $pdf->download('Invoice-' . $order->order_number . '.pdf');
    }
    public function updateItemStatus(Request $request)
    {
        $item = OrderItem::find($request->id);
        if (!$item) return response()->json(['success' => false, 'message' => 'Item not found']);

        $oldStatus = $item->status;
        $newStatus = $request->status;

        DB::beginTransaction();
        try {
            if (in_array($newStatus, ['Cancelled', 'Returned']) && !in_array($oldStatus, ['Cancelled', 'Returned'])) {
                Product::where('id', $item->product_id)->increment('stock', $item->qty);
                $histories = DB::table('loyalty_histories')
                    ->where('order_item_id', $item->id)
                    ->get();

                foreach ($histories as $history) {
                    if ($history->status === 'completed') {
                        Customer::where('id', $history->customer_id)->decrement('loyalty_points', $history->points);
                    }
                }

                DB::table('loyalty_histories')
                    ->where('order_item_id', $item->id)
                    ->update(['status' => 'cancelled']);
            }


            $item->status = $newStatus;
            $item->save();

            $order = Order::find($item->order_id);
            if ($order) {
                $allItems = OrderItem::where('order_id', $order->id)->get();
                $statusValues = $allItems->pluck('status')->unique()->toArray();
                $activeStatuses = array_diff($statusValues, ['Cancelled', 'Returned']);

                if (empty($activeStatuses)) {
                    if ($order->payment_method == 'cod') {
                        $order->payment_status = 'Unpaid';
                    } else {
                        $order->payment_status = 'Refunded';
                    }

                    $order->order_status = (count($statusValues) === 1)
                        ? $statusValues[0]
                        : 'Cancelled';

                    $order->save();
                }
            }


            DB::commit();
            return response()->json(['success' => true, 'message' => 'Item status updated to ' . $newStatus]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong']);
        }
    }
    public function showOrderDetails($id)
    {
        $order = Order::with('orderItems.product')->find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json([
            'order' => $order,
            'items' => $order->orderItems
        ]);
    }


    public function shop(Request $request)
    {
        $userCity = session('user_city');
        $searchQuery = $request->input('query');

        $categories = Category::where('is_active', 1)
            ->whereHas('products.store', function ($q) use ($userCity) {
                if ($userCity) {
                    $q->whereRaw('LOWER(trim(city)) = ?', [strtolower(trim($userCity))]);
                }
            })
            ->with(['subcategories' => function ($query) use ($userCity) {
                $query->whereHas('products.store', function ($q) use ($userCity) {
                    if ($userCity) {
                        $q->whereRaw('LOWER(trim(city)) = ?', [strtolower(trim($userCity))]);
                    }
                });
            }])
            ->withCount(['products' => function ($query) use ($userCity) {
                if ($userCity) {
                    $query->whereHas('store', function ($q) use ($userCity) {
                        $q->whereRaw('LOWER(trim(city)) = ?', [strtolower(trim($userCity))]);
                    });
                }
            }])
            ->get();

        $brands = Brand::where('is_active', 1)
            ->whereHas('products.store', function ($q) use ($userCity) {
                if ($userCity) {
                    $q->whereRaw('LOWER(trim(city)) = ?', [strtolower(trim($userCity))]);
                }
            })
            ->get();

        $productsQuery = Product::where('is_active', 1);

        if (!empty($userCity)) {
            $productsQuery->whereHas('store', function ($q) use ($userCity) {
                $q->whereRaw('LOWER(trim(city)) = ?', [strtolower(trim($userCity))]);
            });
        }

        if ($searchQuery) {
            $productsQuery->where(function ($q) use ($searchQuery) {
                $q->where('name', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('sku', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('sort_description', 'LIKE', "%{$searchQuery}%");
            });
        }

        if ($request->filled('category')) {
            $productsQuery->where('category_id', $request->category);
        }

        if ($request->filled('subcategory')) {
            $productsQuery->where('subcategory_id', $request->subcategory);
        }

        if ($request->filled('brands')) {
            $productsQuery->whereIn('brand_id', $request->brands);
        }

        $perPage = $request->get('per_page', 9);
        $products = $productsQuery->latest()->paginate($perPage)->appends($request->all());

        if ($request->ajax()) {
            return response()->json($products);
        }

        $dealsQuery = Product::where('is_active', true);
        if ($userCity) {
            $dealsQuery->whereHas('store', function ($q) use ($userCity) {
                $q->whereRaw('LOWER(trim(city)) = ?', [strtolower(trim($userCity))]);
            });
        }
        $deals = $dealsQuery->orderBy('price', 'asc')->take(20)->get();

        if ($deals->count() > 0) {
            $deals = $deals->random(min(3, $deals->count()));
        }

        return view('fronend.pages.shop', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'deals' => $deals,
            'query' => $searchQuery
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $couponCode = $request->coupon_code;
        $customer = Customer::where('user_id', Auth::id())->first();

        if (!$customer) {
            return response()->json(['success' => false, 'msg' => 'Please login to apply coupon.']);
        }
        $today = now()->format('Y-m-d');
        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', 1)
            ->whereDate('valid_from', '<=', $today)
            ->whereDate('valid_until', '>=', $today)
            ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'msg' => 'Invalid or expired coupon code.']);
        }

        if ($coupon->usage_limit !== null && $coupon->usage_limit <= 0) {
            return response()->json(['success' => false, 'msg' => 'This coupon usage limit has been reached.']);
        }

        $allCartItems = Cart::where('customer_id', $customer->id)->with('product')->get();
        $cartTotal = 0;

        foreach ($allCartItems as $item) {
            $cartTotal += $item->product->price * $item->quantity;
        }

        if ($cartTotal < $coupon->min_order_amount) {
            return response()->json(['success' => false, 'msg' => 'Minimum order amount for this coupon is ₹' . number_format($coupon->min_order_amount)]);
        }

        $discountAmount = 0;
        if ($coupon->discount_type == 'percentage') {
            $discountAmount = ($cartTotal * $coupon->discount_value) / 100;
            if ($coupon->max_discount && $discountAmount > $coupon->max_discount) {
                $discountAmount = $coupon->max_discount;
            }
        } else {
            $discountAmount = $coupon->discount_value;
        }

        session([
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'discount' => $discountAmount,
                'description' => $coupon->description
            ]
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Coupon applied successfully!',
            'discount' => $discountAmount,
            'code' => $coupon->code
        ]);
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return response()->json(['success' => true, 'msg' => 'Coupon removed.']);
    }
}
