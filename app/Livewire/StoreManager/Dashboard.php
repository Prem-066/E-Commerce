<?php

namespace App\Livewire\StoreManager;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Manager;
use App\Models\Employee;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Dashboard extends Component
{
    public $storeId;
    public $adminId;
    public $storeName;

    public function mount()
    {
        $user = Auth::user();

        if ($user->hasRole('Store Manager')) {
            $manager = Manager::where('user_id', $user->id)->first();
            if ($manager) {
                $this->storeId = $manager->store_id;
                $this->adminId = $manager->admin_id ?? $user->id;
            }
        } elseif ($user->hasRole('Employee POS')) {
            $employee = Employee::where('user_id', $user->id)->first();
            if ($employee) {
                $this->storeId = $employee->store_id;
                $this->adminId = $employee->admin_id;
            }
        }

        if ($this->storeId) {
            $store = Store::find($this->storeId);
            $this->storeName = $store ? $store->name : 'Unknown Store';
        }
    }

    #[Layout('layouts.admin')]
    #[Title('Store Manager Dashboard')]
    public function render()
    {
        $stats = [
            'total_products' => Product::where('store_id', $this->storeId)->count(),
            'total_categories' => Category::where('store_id', $this->storeId)->count(),
            'total_orders' => Order::where('store_id', $this->storeId)->count(),
            'total_sales' => Order::where('store_id', $this->storeId)
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
            'online_orders' => Order::where('store_id', $this->storeId)
                ->where('order_type', 'online')
                ->count(),
            'offline_orders' => Order::where('store_id', $this->storeId)
                ->where('order_type', 'offline')
                ->count(),
        ];

        $recentOrders = Order::where('store_id', $this->storeId)
            ->latest()
            ->take(5)
            ->get();

        $topProducts = Product::where('store_id', $this->storeId)
            ->orderBy('stock', 'asc') // Show low stock products
            ->take(5)
            ->get();

        return view('livewire.store-manager.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'topProducts' => $topProducts
        ]);
    }
}
