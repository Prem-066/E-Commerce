<?php

namespace App\Livewire\StoreManager;

use App\Models\Employee;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Manager;
use App\Models\Store;
use Livewire\Attributes\On;

class Index extends Component
{
   public function triggerDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'type'       => 'warning',
            'title'      => 'Are you sure?',
            'text'       => 'This Employee will be deleted permanently!',
            'id'         => $id,
            'nextAction' => 'deleteConfirmed'
        ]);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($id)
    {
        Employee::findOrFail($id)->delete();
        sweetalert('Employee Deleted Successfully !', 'warning');
    }

    public function triggerStatusManager($id)
    {
        $this->dispatch('swal:confirm', [
            'type'       => 'warning',
            'title'      => 'Are you sure?',
            'text'       => 'Employee status change thai jashe!',
            'id'         => $id,
            'nextAction' => 'statusManagerConfirmed'
        ]);
    }

    #[On('statusManagerConfirmed')]
    public function statusManagerConfirmed($id)
    {
        $employee = Employee::find($id);
        $employee->status = !$employee->status;
        $employee->save();
        sweetalert('Employee status changed Successfully !', 'warning');
    }

    #[Layout('layouts.admin')]
    #[Title('Staff Authority')]
    public function render()
    {
        $storeId = auth()->user()->manager->store_id;
        $employees = Employee::with('user')
            ->where('store_id', $storeId ?? null)
            ->get();
        return view('livewire.store-manager.index', compact('employees'));
    }
}
