<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Order;
use App\Models\User;
use App\Models\Store;
use Carbon\Carbon;

#[Layout('layouts.admin')]
#[Title('Reports')]
class Reports extends Component
{
    public $startDate, $endDate;
    public $selectedStore = null;
    public $selectedUser = null;
    public $totalRevenue, $totalOrders, $cashSales, $onlineSales;
    public $selectedOrder = null;

    public $isAdmin = false;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function updatedSelectedStore()
    {
        $this->selectedUser = null;
        $this->dispatch('refreshTable');
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['startDate', 'endDate', 'selectedUser'])) {
            $this->dispatch('refreshTable');
        }
    }

    public function render()
    {
        $query = Order::with(['employee', 'store'])
            ->whereDate('created_at', '>=', $this->startDate)
            ->whereDate('created_at', '<=', $this->endDate);


        if ($this->selectedStore) {
            $query->where('store_id', $this->selectedStore);
        }

        if ($this->selectedUser) {
            $query->where('employee_id', $this->selectedUser);
        }

        $this->calculateStats(clone $query);

        $allUsers = collect();

        if ($this->selectedStore) {
            $employeeIdsFromOrders = Order::where('store_id', $this->selectedStore)
                ->distinct()
                ->pluck('employee_id')
                ->toArray();

            $storeAdminId = Store::where('id', $this->selectedStore)->value('admin_id');

            $allIds = array_unique(array_filter(array_merge($employeeIdsFromOrders, [$storeAdminId])));

            $allUsers = User::whereIn('id', $allIds)->get();
        } else {
            $allUsers = User::all();
        }

        return view('livewire.super-admin.reports', [
            'reports' => $query->latest()->paginate(15),
            'allStores' => Store::all(),
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
    }
}
