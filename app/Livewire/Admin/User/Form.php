<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Spatie\Permission\Models\Permission;
use Livewire\Component;

class Form extends Component
{
    public $availablePermissions = [];
    public $selectedPermissions = [];
    public $userId;
    public $name, $email, $password, $role;


    public function mount(User $user = null)
    {
        // બધી જ ઉપલબ્ધ પરમિશન લોડ કરો
        $this->availablePermissions = Permission::pluck('name')->toArray();

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
            // રોલની ડિફોલ્ટ પરમિશન ખેંચીને લાવો
            $rolePerms = $role->permissions->pluck('name')->toArray();

            if ($this->userId) {
                // એડિટ મોડમાં: હાલની પરમિશન અને નવા રોલની પરમિશન ભેગી કરો
                $this->selectedPermissions = array_unique(array_merge($this->selectedPermissions, $rolePerms));
            } else {
                // ક્રિએટ મોડમાં: સીધી જ તે રોલની પરમિશન સિલેક્ટ કરી દો
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

        // 1️⃣ Create or update user
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

        // 2️⃣ Assign the selected role
        $user->syncRoles([$this->role]);

        // 3️⃣ Get default permissions of the role
        $rolePermissions = Role::findByName($this->role)->permissions->pluck('name')->toArray();

        // 4️⃣ Determine extra permissions (user-specific only)
        $extraPermissions = array_diff($this->selectedPermissions, $rolePermissions);

        // 5️⃣ Sync only extra permissions to the user
        $user->syncPermissions($extraPermissions);

        // 6️⃣ Success message & redirect

        flash()->addSuccess('User Saved Successfully!');
        return $this->redirectRoute('admin.users.index', navigate: true);
    }

    #[Layout('layouts.admin')]
    #[Title('User Form')]
    public function render()
    {
        $roles = Role::whereNotIn('name', ['Super Admin', 'Admin'])->get();
        return view('livewire.admin.user.form', compact('roles'));
    }
}
