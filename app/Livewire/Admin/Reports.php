<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Order;
use App\Models\Store;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.admin')]
#[Title('Reports')]
class Reports extends Component
{

    public $startDate, $endDate;
    public $selectedUser = null;
    public $totalRevenue, $totalOrders, $cashSales, $onlineSales;
    public $selectedOrder = null;
    public $storeId;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $user = auth()->user();
        $this->storeId = Store::where('admin_id', $user->id)->value('id');
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function updated($propertyName)
    {
        // Livewire automatically re-renders on property change — no extra action needed.
        // This hook intentionally left empty to ensure filter changes trigger re-render.
        $this->dispatch('refreshDataTable');
    }


    public function render()
    {
        $query = Order::with(['employee'])
            ->where('store_id', $this->storeId)
            ->whereDate('created_at', '>=', $this->startDate)
            ->whereDate('created_at', '<=', $this->endDate);

        if ($this->selectedUser) {
            $query->where('employee_id', $this->selectedUser);
        }

        $this->calculateStats(clone $query);

        $allUsers = User::where(function ($q) {
            $q->whereHas('employee', function ($query) {
                $query->where('store_id', $this->storeId);
            })
                ->orWhereHas('manager', function ($query) {
                    $query->where('store_id', $this->storeId);
                })
                ->orWhere('id', Auth::id());
        })
            ->get();
        return view('livewire.admin.reports', [
            'reports' => $query->latest()->get(),
            'allUsers' => $allUsers,
        ]);
    }
    private function calculateStats($query)
    {
        $this->totalRevenue = $query->sum('total_amount');
        $this->totalOrders = $query->count();
        $this->cashSales = (clone $query)->where('payment_method', 'cash')->sum('total_amount');
        $this->onlineSales = (clone $query)->where('payment_method', '!=', 'cash')->sum('total_amount');
    }

    public function viewOrderDetails($orderId)
    {
        $this->selectedOrder = Order::with(['items.product', 'employee'])->find($orderId);
        $this->dispatch('openModal');
        $this->dispatch('refreshDataTable');
    }
}
