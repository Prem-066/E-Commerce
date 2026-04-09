<?php

namespace App\Livewire\Admin\Products;

use App\Models\Brand;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Employee;
use App\Models\store;
use App\Models\Subcategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithFileUploads;

    public $productId, $delivery_charge, $return_policy_days, $name, $price, $discount_price, $stock, $description, $sort_description, $category_id, $subcategory_id, $sku, $brand_id;
    public $main_image, $old_main_image;
    public $gallery_images = [];
    public $existing_gallery = [];

    public $editMode = false;
    public $subcategories = [];

    public function updatedCategoryId($value)
    {
        $this->subcategories = Subcategory::where('category_id', $value)->get();
        $this->subcategory_id = null;
    }

    public function mount()
    {
        $editId = request()->query('edit_id');
        $this->delivery_charge = 40;
        $this->return_policy_days = 7;
        if ($editId) {
            $this->edit($editId);
        }
    }

    public function save()
    {
        $userId = auth()->user()->id;
        $storeId = null;
        $createdBy = null;

        $isAdmin = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_has_roles.model_id', $userId)
            ->where('roles.name', 'Admin')
            ->exists();

        if ($isAdmin) {
            $storeId = Store::where('admin_id', $userId)->value('id');
            $createdBy = $userId;
        } else {
            $managerAdminId = DB::table('managers')->where('user_id', $userId)->value('admin_id');

            if ($managerAdminId) {
                $storeId = Store::where('admin_id', $managerAdminId)->value('id');
                $createdBy = $managerAdminId;
            } else {
                $employee = Employee::where('user_id', $userId)->first();
                if ($employee) {
                    $storeId = $employee->store_id;
                    $createdBy = Store::where('id', $storeId)->value('admin_id');
                }
            }
        }
        if (!$storeId) {
            abort(403, 'Your account is not linked with any store.');
        }

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')
                    ->where(function ($query) use ($storeId) {
                        return $query->where('store_id', $storeId);
                    })
                    ->ignore($this->editMode ? $this->productId : null)
            ],
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric|gte:price',
            'category_id' => 'required',
            'stock' => 'required|integer',
            'brand_id' => 'required',
            'return_policy_days' => 'required|integer',
            'main_image' => $this->editMode ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:2048',
        ];
        $this->validate($rules, [
            'name.unique' => 'This product name already exists in your store.'
        ]);

        $finalSku = $this->sku ?: strtoupper(Str::slug($this->name) . '-' . Str::random(4));
        $data = [
            'store_id' => $storeId,
            'created_by' => $createdBy,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'sku' => $finalSku,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'stock' => $this->stock,
            'brand_id' => $this->brand_id,
            'delivery_charge' => $this->delivery_charge,
            'return_policy_days' => $this->return_policy_days,
            'description' => $this->description,
            'sort_description' => $this->sort_description,
        ];

        if ($this->editMode) {
            $product = Product::find($this->productId);

            if ($this->main_image) {
                if ($product->image) Storage::disk('public')->delete($product->image);
                $data['image'] = $this->main_image->store('products/main', 'public');
            }

            $product->update($data);
        } else {
            if ($this->main_image) {
                $data['image'] = $this->main_image->store('products/main', 'public');
            }
            $product = Product::create($data);
        }

        if (!empty($this->gallery_images)) {
            foreach ($this->gallery_images as $img) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $img->store('products/gallery', 'public'),
                ]);
            }
        }

        flash()->addSuccess($this->editMode ? 'Product Updated' : 'Product Created');
        $this->resetForm();
        $this->dispatch('refresh-products');
    }

    public function edit($id)
    {
        $this->resetForm();

        $this->editMode = true;
        $product = Product::with('gallery')->findOrFail($id);

        $this->productId = $id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->subcategories = Subcategory::where('category_id', $this->category_id)->get();
        $this->subcategory_id = $product->subcategory_id;

        $this->description = $product->description;
        $this->discount_price = $product->discount_price;
        $this->delivery_charge = $product->delivery_charge;
        $this->return_policy_days = $product->return_policy_days;
        $this->sort_description = $product->sort_description;
        $this->sku = $product->sku;
        $this->old_main_image = $product->image;
        $this->existing_gallery = $product->gallery;
        $this->dispatch('update-editor-content', content: $this->description);
    }

    public function toggleStatus($id)
    {
        $sub = Product::findOrFail($id);
        $statusText = $sub->is_active ? 'Inactive' : 'Active';

        $this->dispatch('swal:confirm', [
            'type'       => 'info',
            'title'      => 'Change Status?',
            'text'       => "Do you want to make this product $statusText?",
            'id'         => $id,
            'nextAction' => 'statusConfirmedSub'
        ]);
    }

    #[On('statusConfirmedSub')]
    public function statusConfirmedSub($id)
    {
        $sub = Product::findOrFail($id);
        $sub->is_active = !$sub->is_active;
        $sub->save();

        sweetalert('Product Status Updated Successfully!', 'success');
        $this->dispatch('refreshTable');
    }


    public function removeSelectedImage($index)
    {
        if (isset($this->gallery_images[$index])) {
            unset($this->gallery_images[$index]);
            $this->gallery_images = array_values($this->gallery_images);
        }
    }

    public function triggerDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'type'       => 'warning',
            'title'      => 'Delete Product?',
            'text'       => 'This Product will be deleted permanently!',
            'id'         => $id,
            'nextAction' => 'deleteConfirmed'
        ]);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($id)
    {
        $product = Product::find($id);
        if ($product) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            foreach ($product->gallery as $img) {
                Storage::disk('public')->delete($img->image_path);
            }
            $product->delete();
        }
        sweetalert('Products Deleted Successfully !', 'warning');
        $this->dispatch('refresh-products');
    }

    public function resetForm()
    {
        $this->reset(['name', 'price', 'delivery_charge', 'return_policy_days', 'discount_price', 'stock', 'description', 'sort_description', 'category_id', 'subcategory_id', 'brand_id', 'sku', 'main_image', 'gallery_images', 'existing_gallery', 'editMode', 'productId', 'old_main_image']);
        $this->delivery_charge = 40;
        $this->return_policy_days = 7;
        $this->dispatch('update-editor-content', content: '');
    }

    #[On('refresh-products')]
    public function refresh() {}

    #[Layout('layouts.admin')]
    #[Title('Products')]
    public function render()
    {
        abort_if(!auth()->user()->can('view products'), 403, 'You do not have permission to view this page.');

        $userId = auth()->user()->id;
        $userRoles = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_has_roles.model_id', $userId)
            ->pluck('roles.name')
            ->toArray();

        if (in_array('Admin', $userRoles)) {
            $adminId = $userId;
        } elseif (in_array('Store Manager', $userRoles)) {
            $adminId = DB::table('managers')
                ->where('user_id', $userId)
                ->value('admin_id');
        } elseif (in_array('Employee POS', $userRoles)) {
            $id = DB::table('employees')
                ->where('user_id', $userId)
                ->value('admin_id');
            $adminId = DB::table('managers')->where('user_id', $id)->value('admin_id');
        } else {
            $adminId = null;
        }

        $storeId = Store::where('admin_id', $adminId)->value('id');

        $products = Product::where('store_id', $storeId)
            ->latest()
            ->get();

        $brands = Brand::where('store_id', $storeId)
            ->latest()
            ->get();

        $categories = Category::where('store_id', $storeId)
            ->latest()
            ->get();

        return view('livewire.admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}
