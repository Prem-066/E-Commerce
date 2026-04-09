<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $low_stock_products = [];
    public $selectedOrder = null;
    public $todaySales = 0;
    public $todayOrders = 0;
    public $lowStockCount = 0;
    public $cashInHand = 0;
    public $onlinePayment = 0;
    public $employeStore;
    public $recentOrders = [];

    public function mount()
    {
        $employee = auth()->user();
        $today = now()->startOfDay();

        $this->employeStore = Employee::where('user_id', $employee->id)->value('store_id');

        $this->todaySales = Order::where('employee_id', $employee->id)
            ->where('payment_status', 'paid')
            // ->where('created_at', '>=', $today)  
            ->sum('total_amount');

        $this->todayOrders = Order::where('employee_id', $employee->id)
            // ->where('created_at', '>=', $today)
            ->count();

        $this->cashInHand = Order::where('employee_id', $employee->id)
            // ->where('created_at', '>=', $today)
            ->where('payment_method', 'cash')
            ->sum('total_amount');

        $this->onlinePayment = Order::where('employee_id', $employee->id)
            // ->where('created_at', '>=', $today)
            ->where('payment_method', 'online')
            ->sum('total_amount');

        $this->lowStockCount = Product::where('store_id', $this->employeStore)
            ->where('stock', '<=', 20)
            ->count();

        $this->recentOrders = Order::where('employee_id', $employee->id)
            ->with('items')
            ->latest()
            ->get();

        $this->low_stock_products = Product::where('store_id', $this->employeStore)
            ->where('stock', '<=', 20)
            ->orderBy('stock', 'asc')
            ->get();

        if (request()->has('showOrder')) {
            $orderId = request()->get('showOrder');
            $this->loadOrderForDashboard($orderId);
        }
    }

    public function loadOrderForDashboard($orderId)
    {
        $this->selectedOrder = \App\Models\Order::with('items.product')->find($orderId);

        if ($this->selectedOrder) {
            $this->dispatch('trigger-model-open');
        }
    }

    #[Layout('layouts.admin')]
    #[Title('Employee')]
    public function render()
    {
        if (!Auth::user()->can('view stores')) {
            abort(403);
        }
        return view('livewire.employee.dashboard');
    }
}
