<?php

namespace App\Livewire\SuperAdmin\Store;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $storeId;
    public $name, $email, $phone, $admin_id, $address;
    public $status = true;
    public $admin = [];

    public function mount(Store $store = null)
    {
        $this->admin = User::role('Admin')->get();
        if ($store && $store->exists) {
            $this->storeId = $store->id;
            $this->name = $store->name;
            $this->email = $store->email;
            $this->address = $store->address;
            $this->phone = $store->phone;
            $this->admin_id = $store->admin_id;
            $this->status = (bool) $store->status;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'admin_id' => 'required|exists:users,id',
            'status' => 'boolean',
        ]);

        Store::updateOrCreate(
            ['id' => $this->storeId],
            [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'admin_id' => $this->admin_id,
                'status' => $this->status,
                'created_by' => Auth::id(),
            ]
        );
        flash()->addSuccess('Store saved successfully!');
        return $this->redirectRoute('superadmin.stores.index', navigate: false);
    }


    #[Layout('layouts.admin')]
    #[Title('Store')]
    public function render()
    {
        return view('livewire.super-admin.store.form');
    }
}
