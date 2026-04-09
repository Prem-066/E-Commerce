<?php

namespace App\Livewire\Admin\Manager;

use App\Models\Employee;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Manager;
use App\Models\Store;
use Livewire\Attributes\On;

class Index extends Component
{
    public function managerdelete($id)
    {
        $this->dispatch('swal:confirm', [
            'type'       => 'warning',
            'title'      => 'Are you sure?',
            'text'       => 'This Employee will be deleted permanently!',
            'id'         => $id,
            'nextAction' => 'deleteConfirmeda'
        ]);
    }

    #[On('deleteConfirmeda')]
    public function deleteConfirmeda($id)
    {
        Manager::findOrFail($id)->delete();
        sweetalert('Manager Deleted Successfully !', 'warning');
        $this->dispatch('refreshTable');
    }

    public function triggerStatusManagerdes($id)
    {
        $this->dispatch('swal:confirm', [
            'type'       => 'warning',
            'title'      => 'Are you sure?',
            'text'       => 'Manager status change thai jashe!',
            'id'         => $id,
            'nextAction' => 'statusManagerConfirmedes'
        ]);
    }


    #[On('statusManagerConfirmedes')]
    public function statusManagerConfirmedes($id)
    {
        $manager = Manager::find($id);
        $manager->status = !$manager->status;
        $manager->save();
        sweetalert('Manager status changed Successfully !', 'warning');
        $this->dispatch('refreshTable');
    }

    #[Layout('layouts.admin')]
    #[Title('Manager')]
    public function render()
    {
        $store = Store::where('admin_id', auth()->id())->first();

        $manager = Manager::with('user')
            ->where('store_id', $store->id ?? null)
            ->get();
        return view('livewire.admin.manager.index', compact('manager'));
    }
}
