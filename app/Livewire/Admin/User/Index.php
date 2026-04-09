<?php

namespace App\Livewire\Admin\User;

use App\Models\store;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

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
    $userId = auth()->id(); 

    $isAdmin = DB::table('model_has_roles')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->where('model_has_roles.model_id', $userId)
        ->where('roles.name', 'Admin')
        ->exists();

    if ($isAdmin) {
        $adminId = $userId;
    } else {
        $adminId = DB::table('managers')
            ->where('user_id', $userId)
            ->value('admin_id');

        if (!$adminId) {
            abort(403, 'Unauthorized access.');
        }
    }

    $users = User::with('roles')
        ->whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', ['Super Admin', 'Admin']);
        })
        ->whereHas('manager', function ($query) use ($adminId) {
            $query->where('admin_id', $adminId);
        })
        ->get();

    return view('livewire.admin.user.index', compact('users'));
}
}
