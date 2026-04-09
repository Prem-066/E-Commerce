<?php

namespace App\Livewire\SuperAdmin\Store;
use Livewire\Attributes\On;
use App\Models\Store;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Index extends Component
{
    #[Layout('layouts.admin')]
    #[Title('Store')]
    public function render()
    {
        $stores = Store::with('Admin')->get();
        return view('livewire.super-admin.store.index', compact('stores'));
    }

    public function triggerStatusStore($id)
    {
        $this->dispatch('swal:confirm', [
            'type'       => 'warning',
            'title'      => 'Are you sure?',
            'text'       => 'Store status change thai jashe!',
            'id'         => $id,
            'nextAction' => 'statusConfirmed'
        ]);
    }

    #[On('statusConfirmed')]
    public function statusConfirmed($id)
    {
        $store = Store::find($id);
        $store->status = !$store->status;
        $store->save();
        sweetalert('Store status changed Successfully !', 'warning');

    }
    public function triggerDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'type'       => 'warning',
            'title'      => 'Are you sure?',
            'text'       => 'User delete thai jashe!',
            'id'         => $id,
            'nextAction' => 'deleteConfirmed'
        ]);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($id)
    {
        Store::find($id)?->delete();
        sweetalert('User deleted Successfully !', 'warning');

    }
}
