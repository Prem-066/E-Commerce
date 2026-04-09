<?php

namespace App\Livewire\Admin\Manager;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\User;
use App\Models\Manager;
use App\Models\Store;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Form extends Component
{
    public $managerId;
    public $phone, $address, $salary, $joining_date, $status = 1;

    public $availablePermissions = [];
    public $selectedPermissions = [];
    public $userId;
    public $name, $email, $password, $role;


    public function mount(User $user = null, Manager $manager = null)
    {
        $admin = auth()->user();

        $permsCollection = ($admin instanceof \App\Models\User)
            ? $admin->getAllPermissions()
            : \App\Models\User::find(auth()->id())->getAllPermissions();

        $this->availablePermissions = $permsCollection->groupBy(function ($perm) {
            $parts = explode(' ', $perm->name);
            return count($parts) > 1 ? end($parts) : 'General';
        })->toArray();

        if ($manager && $manager->exists) {
            $this->managerId = $manager->id;
            $this->phone = $manager->phone;
            $this->address = $manager->address;
            $this->salary = $manager->salary;
            $this->joining_date = $manager->joining_date;
            $this->status = (bool) $manager->status;
            $user = $manager->user;
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->getRoleNames()->first();
            $this->selectedPermissions = $user->getAllPermissions()->pluck('name')->toArray();
        } else {
            $this->status = true;
            $this->selectedPermissions = [];
        }
    }
    public function updatedRole($value)
    {
        if (!$value) {
            $this->selectedPermissions = [];
            return;
        }

        $role = Role::where('name', $value)->first();

        if ($role) {
            $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        }
    }

    public function save()
    {
        $store = Store::where('admin_id', auth()->id())->firstOrFail();

        $this->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . ($this->managerId ? Manager::find($this->managerId)->user_id : 'NULL'),
            'password' => $this->managerId ? 'nullable|min:6' : 'required|min:6',
            'role'     => 'required',
            'phone'    => 'required',
            'salary'   => 'required|numeric',
        ]);

        if ($this->managerId) {
            $manager = Manager::findOrFail($this->managerId);
            $user = User::findOrFail($manager->user_id);

            $userData = [
                'name'  => $this->name,
                'email' => $this->email,
            ];
            if ($this->password) {
                $userData['password'] = Hash::make($this->password);
            }
            $user->update($userData);

            $manager->update([
                'phone'        => $this->phone,
                'address'      => $this->address,
                'salary'       => $this->salary,
                'joining_date' => $this->joining_date,
                'status'       => $this->status ? 1 : 0,
            ]);
        } else {
            // --- CREATE MODE ---
            $user = User::create([
                'name'     => $this->name,
                'email'    => $this->email,
                'password' => Hash::make($this->password),
            ]);

            Manager::create([
                'user_id'      => $user->id,
                'store_id'     => $store->id,
                'admin_id'     => auth()->id(),
                'phone'        => $this->phone,
                'address'      => $this->address,
                'salary'       => $this->salary,
                'joining_date' => $this->joining_date,
                'status'       => $this->status ? 1 : 0,
            ]);
        }

        // Role ane Permissions Sync (Spatie)
        $user->syncRoles([$this->role]);

        $rolePermissions = Role::findByName($this->role)->permissions->pluck('name')->toArray();
        $extraPermissions = array_diff($this->selectedPermissions, $rolePermissions);
        $user->syncPermissions($extraPermissions);

        flash()->addSuccess($this->managerId ? 'Manager updated successfully!' : 'Manager created successfully!');
        $this->dispatch('refreshTable');
        return $this->redirectRoute('admin.manager.index', navigate: true);
    }

    #[Layout('layouts.admin')]
    #[Title('Manager')]
    public function render()
    {
        $roles = Role::whereNotIn('name', ['Super Admin', 'Admin'])->get();
        return view('livewire.admin.manager.form', compact('roles'));
    }
}
