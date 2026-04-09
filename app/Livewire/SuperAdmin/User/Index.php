<?php

namespace App\Livewire\SuperAdmin\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\User;
use Livewire\Attributes\On;

class Index extends Component
{

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
        User::find($id)?->delete();
        sweetalert('User deleted Successfully !', 'warning');
    }

    #[Layout('layouts.admin')]
    #[Title('Users')]
    public function render()
    {
        $users = User::with('roles')
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'Super Admin');
            })
            ->get();
        return view('livewire.super-admin.user.index', compact('users'));
    }
}
