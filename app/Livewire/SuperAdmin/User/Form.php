<?php

namespace App\Livewire\SuperAdmin\User;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Spatie\Permission\Models\Permission;



class Form extends Component
{
    public $availablePermissions = [];
    public $selectedPermissions = [];
    public $userId;
    public $name, $email, $password, $role;


    public function mount(User $user = null)
    {
        // બધી જ ઉપલબ્ધ પરમિશન લોડ કરો
        // $this->availablePermissions = Permission::pluck('name')->toArray();
        $allPerms = Permission::all();

        // આ લોજિકથી 'create categories' અને 'edit categories' બંને 'categories' ગ્રુપમાં જશે
        $this->availablePermissions = $allPerms->groupBy(function ($perm) {
            $parts = explode(' ', $perm->name);
            return count($parts) > 1 ? end($parts) : 'Other';
        })->toArray();

        if ($user && $user->exists) {
            // Edit Mode
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->getRoleNames()->first(); // યુઝરનો હાલનો રોલ

            // યુઝરની બધી જ પરમિશન (Role + Direct) લોડ કરો
            $this->selectedPermissions = $user->getAllPermissions()->pluck('name')->toArray();
        } else {
            // Create Mode
            $this->selectedPermissions = [];
        }
    }

    // જ્યારે Dropdown માંથી Role બદલાય ત્યારે
    public function updatedRole($value)
    {
        if (!$value) {
            $this->selectedPermissions = [];
            return;
        }

        $role = Role::where('name', $value)->first();

        if ($role) {
            $rolePerms = $role->permissions->pluck('name')->toArray();

            if ($this->userId) {
                $this->selectedPermissions = array_unique(array_merge($this->selectedPermissions, $rolePerms));
            } else {
                $this->selectedPermissions = $rolePerms;
            }
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => $this->userId ? 'nullable|min:6' : 'required|min:6',
            'role' => 'required'
        ]);

        $user = User::updateOrCreate(
            ['id' => $this->userId],
            [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password
                    ? Hash::make($this->password)
                    : User::find($this->userId)?->password
            ]
        );

        $user->syncRoles([$this->role]);

        $rolePermissions = Role::findByName($this->role)->permissions->pluck('name')->toArray();

        $extraPermissions = array_diff($this->selectedPermissions, $rolePermissions);

        $user->syncPermissions($extraPermissions);


        flash()->addSuccess('User Saved Successfully!');
        return $this->redirectRoute('superadmin.users.index', navigate: true);
    }

    #[Layout('layouts.admin')]
    #[Title('Users')]
    public function render()
    {
        $roles = Role::where('name', '!=', 'Super Admin')->get();

        return view('livewire.super-admin.user.form', compact('roles'));
    }
}
