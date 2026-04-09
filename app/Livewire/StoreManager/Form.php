<?php

namespace App\Livewire\StoreManager;

use App\Models\Employee;
use App\Models\Manager;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class Form extends Component
{
    public $managerId; // This is actually Employee ID
    public $userId;
    public $name, $email, $password, $role;

    // New Fields as per your request
    public $phone, $address, $designations, $salary, $joining_date, $employment_type, $status = 1;

    public $availablePermissions = [];
    public $selectedPermissions = [];

    // mount parameter nu naam route na {employee} sathe match thavu joie
    public function mount(Employee $employee = null)
    {
        $adminUser = auth()->user();

        $permsCollection = $adminUser->getAllPermissions();
        $this->availablePermissions = $permsCollection->groupBy(function ($perm) {
            $parts = explode(' ', $perm->name);
            return count($parts) > 1 ? end($parts) : 'General';
        })->toArray();

        if ($employee && $employee->exists) {
            $this->managerId = $employee->id;
            $this->phone = $employee->phone;
            $this->address = $employee->address;
            $this->designations = $employee->designation;
            $this->salary = $employee->salary;
            $this->joining_date = $employee->joining_date;
            $this->employment_type = $employee->employment_type;
            $this->status = (bool) $employee->status;

            $user = $employee->user;
            if ($user) {
                $this->userId = $user->id;
                $this->name = $user->name;
                $this->email = $user->email;
                $this->role = $user->getRoleNames()->first();
                $this->selectedPermissions = $user->getAllPermissions()->pluck('name')->toArray();
            }
        } else {
            $this->status = true;
            $this->employment_type = 'Full-time';
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
        // $storeId = auth()->user()->manager->store_id;

        $userId = auth()->user()->id;
        $storeId = null;
        $createdBy = null;

        $isAdmin = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_has_roles.model_id', $userId)
            ->where('roles.name', 'Admin')
            ->exists();

        if ($isAdmin) {
            $storeId = Store::where('admin_id', $userId)->value('id');
            $createdBy = $userId;
        } else {
            $managerAdminId = DB::table('managers')->where('user_id', $userId)->value('admin_id');

            if ($managerAdminId) {
                $storeId = Store::where('admin_id', $managerAdminId)->value('id');
                $createdBy = $managerAdminId;
            } else {
                $employee = Employee::where('user_id', $userId)->first();
                if ($employee) {
                    $storeId = $employee->store_id;
                    $createdBy = Store::where('id', $storeId)->value('admin_id');
                }
            }
        }

        $this->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . ($this->userId ?? 'NULL'),
            'password'        => $this->managerId ? 'nullable|min:6' : 'required|min:6',
            'role'            => 'required',
            'designations'    => 'required|string',
            'employment_type' => 'required',
            'phone'           => 'required',
            'salary'          => 'required|numeric',
            'joining_date'    => 'required|date',
        ]);

        if ($this->managerId) {
            $employee = Employee::findOrFail($this->managerId);
            $user = User::findOrFail($employee->user_id);

            $user->update([
                'name'  => $this->name,
                'email' => $this->email,
                'password' => $this->password ? Hash::make($this->password) : $user->password,
            ]);
            $employee->update([
                'phone'           => $this->phone,
                'address'         => $this->address,
                'designation'    => $this->designations,
                'salary'          => $this->salary,
                'joining_date'    => $this->joining_date,
                'employment_type' => $this->employment_type,
                'status'          => $this->status ? 1 : 0,
            ]);
        } else {
            $user = User::create([
                'name'     => $this->name,
                'email'    => $this->email,
                'password' => Hash::make($this->password),
            ]);

            Employee::create([
                'user_id'         => $user->id,
                'store_id'        => $storeId,
                'admin_id'        => $createdBy,
                'phone'           => $this->phone,
                'address'         => $this->address,
                'designation'    => $this->designations,
                'salary'          => $this->salary,
                'joining_date'    => $this->joining_date,
                'employment_type' => $this->employment_type,
                'status'          => $this->status ? 1 : 0,
            ]);
        }

        $user->syncRoles([$this->role]);
        $rolePermissions = Role::findByName($this->role)->permissions->pluck('name')->toArray();
        $extraPermissions = array_diff($this->selectedPermissions, $rolePermissions);
        $user->syncPermissions($extraPermissions);

        if ($createdBy) {
            flash()->addSuccess($this->managerId ? 'Staff updated successfully!' : 'Staff created successfully!');
            return $this->redirectRoute('store.manager.index', navigate: true);
        } else {
            flash()->addSuccess($this->managerId ? 'Staff updated successfully!' : 'Staff created successfully!');
            return $this->redirectRoute('store.manager.index', navigate: true);
        }
    }
    #[Layout('layouts.admin')]
    #[Title('Staff Management')]
    public function render()
    {
        $roles = Role::whereNotIn('name', ['Super Admin', 'Admin', 'Store Manager'])->get();
        return view('livewire.store-manager.form', compact('roles'));
    }
}
