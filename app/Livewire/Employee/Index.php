<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;


class Index extends Component
{
    

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[Layout('layouts.admin')]
    #[Title('Inventory')]
    public function render()
    {
        $employee = Employee::where('user_id', auth()->id())->first();

        if (!$employee) {
            return view('livewire.employee.index', [
                'products' => collect([])
            ]);
        }

        $products = \App\Models\Product::where('store_id', $employee->store_id)
            ->with(['category', 'subcategory'])
            ->latest()
            ->get();

        return view('livewire.employee.index', compact('products'));
    }
}
