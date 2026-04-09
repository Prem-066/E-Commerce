<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $storeId;
    public $stats = [];

    public function mount()
    {
        $this->storeId = Store::where('admin_id', auth()->id())->value('id');

        if ($this->storeId) {
            $this->loadStats();
        }
    }

    public function loadStats()
    {
        $this->stats['total_revenue'] = Order::where('store_id', $this->storeId)->where('payment_status', 'paid')->sum('total_amount');
        $this->stats['total_pending'] = Order::where('store_id', $this->storeId)->where('payment_status', 'pending')->sum('total_amount');
        $this->stats['total_orders'] = Order::where('store_id', $this->storeId)->count();
        $this->stats['cancelled_orders'] = Order::where('store_id', $this->storeId)->where('order_status', 'Cancelled')->count();
        $this->stats['total_products'] = Product::where('store_id', $this->storeId)->count();

        $this->stats['low_stock_count'] = Product::where('store_id', $this->storeId)
            ->where('stock', '<', 10)
            ->count();

        $this->stats['recent_orders'] = Order::where('store_id', $this->storeId)
            ->latest()
            ->get();

        $this->stats['low_stock_products'] = Product::where('store_id', $this->storeId)
            ->where('stock', '<', 20)
            ->orderBy('stock', 'asc')
            ->get();
    }

    #[Layout('layouts.admin')]
    #[Title('Admin')]
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
