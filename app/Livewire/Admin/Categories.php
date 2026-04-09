<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Store;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

use Livewire\WithFileUploads;


class Categories extends Component
{
    use WithFileUploads;
    public $name, $description, $is_active = true;
    public $categoryId;
    public $editMode = false;
    public $activeTab = 'category';
    public $sub_name, $category_id, $subCategoryId;
    public $brands;
    public $brand_id;
    public $brand_name;
    public $logo;

    public function resetForm()
    {
        $this->reset([
            'name',
            'description',
            'is_active',
            'categoryId',
            'editMode',
            'sub_name',
            'category_id',
            'subCategoryId',
            'brand_id',
            'brand_name',
            'logo',
            'old_logo'
        ]);

        $this->is_active = true;
    }

    public function save()
    {
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

        if (!$storeId) {
            abort(500, 'Store not found');
        }

        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->where(function ($query) use ($storeId) {
                    return $query->where('store_id', $storeId);
                })
            ]
        ], [
            'name.unique' => 'This category name already exists in your store.'
        ]);

        Category::create([
            'store_id'   => $storeId,
            'created_by' => $createdBy,
            'name'       => $this->name,
            'is_active'  => 1,
        ]);

        $this->resetForm();
        flash()->addSuccess('Category Created Successfully!');
        $this->dispatch('refreshTable');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->editMode = true;
        $this->dispatch('$refresh');
    }

    public function update()
    {
        $category = Category::findOrFail($this->categoryId);
        $storeId = $category->store_id;

        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->where(function ($query) use ($storeId) {
                        return $query->where('store_id', $storeId);
                    })
                    ->ignore($category->id)
            ]
        ], [
            'name.unique' => 'This category name already exists in your store.'
        ]);

        $category->update([
            'name' => $this->name,
        ]);

        $this->resetForm();
        flash()->addSuccess('Category Updated Successfully!');
        $this->dispatch('refreshTable');
    }
    public function triggerStatus($id, $nextStatus)
    {
        $statusText = $nextStatus ? 'Active' : 'Inactive';

        $this->dispatch('swal:confirm', [
            'type'       => 'info',
            'title'      => 'Change Status?',
            'text'       => "Do you want to make this Category $statusText?",
            'id'         => $id,
            'nextAction' => 'statusConfirmed'
        ]);
    }

    #[On('statusConfirmed')]
    public function statusConfirmed($id)
    {
        $category = Category::findOrFail($id);
        $category->is_active = !$category->is_active;
        $category->save();

        sweetalert('Status Updated Successfully!', 'success');
        $this->dispatch('refreshTable');
    }

    public function triggerDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'type'       => 'warning',
            'title'      => 'Are you sure?',
            'text'       => 'This Category will be deleted permanently!',
            'id'         => $id,
            'nextAction' => 'deleteConfirmed'
        ]);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($id)
    {
        Category::findOrFail($id)->delete();
        sweetalert('Category Deleted Successfully !', 'warning');
        $this->dispatch('refreshTable');
    }

    public function saveSub()
    {
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
            'category_id' => 'required',
            'sub_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('subcategories', 'name')->where(function ($query) use ($storeId) {
                    return $query->where('store_id', $storeId)
                        ->where('category_id', $this->category_id);
                })
            ]
        ], [
            'sub_name.unique' => 'This subcategory already exists in the selected category.'
        ]);

        Subcategory::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'store_id' => $storeId,
            'category_id' => $this->category_id,
            'created_by' => $createdBy,
            'name' => $this->sub_name,
            'is_active' => 1,
        ]);

        $this->reset(['sub_name', 'category_id']);
        flash()->addSuccess('Subcategory Created Successfully!');
       $this->dispatch('refreshTable');
    }

    public function editSub($id)
    {
        $sub = Subcategory::findOrFail($id);
        $this->subCategoryId = $sub->id;
        $this->sub_name = $sub->name;
        $this->category_id = $sub->category_id;
        $this->editMode = true;
    }

    public function updateSub()
    {
        $sub = Subcategory::findOrFail($this->subCategoryId);
        $storeId = $sub->store_id;

        $this->validate([
            'category_id' => 'required',
            'sub_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('subcategories', 'name')
                    ->where(function ($query) use ($storeId) {
                        return $query->where('store_id', $storeId)
                            ->where('category_id', $this->category_id);
                    })
                    ->ignore($sub->id)
            ]
        ], [
            'sub_name.unique' => 'This subcategory already exists in this category.'
        ]);

        $sub->update([
            'name' => $this->sub_name,
            'category_id' => $this->category_id,
        ]);

        $this->resetForm();
        flash()->addSuccess('Subcategory Updated Successfully!');
        $this->dispatch('refreshTable');
    }

    public function triggerDeleteSub($id)
    {
        $this->dispatch('swal:confirm', [
            'type'       => 'warning',
            'title'      => 'Are you sure?',
            'text'       => 'This Subcategory will be deleted permanently!',
            'id'         => $id,
            'nextAction' => 'deleteConfirmedSub'
        ]);
    }

    #[On('deleteConfirmedSub')]
    public function deleteConfirmedSub($id)
    {
        $sub = Subcategory::findOrFail($id);
        $sub->delete();

        sweetalert('Subcategory Deleted Successfully!', 'warning');
        $this->dispatch('refreshTable');
    }

    public function triggerStatusSub($id)
    {
        $sub = Subcategory::findOrFail($id);
        $statusText = $sub->is_active ? 'Inactive' : 'Active';

        $this->dispatch('swal:confirm', [
            'type'       => 'info',
            'title'      => 'Change Status?',
            'text'       => "Are you sure you want to make this subcategory $statusText?",
            'id'         => $id,
            'nextAction' => 'statusConfirmedSub'
        ]);
    }

    #[On('statusConfirmedSub')]
    public function statusConfirmedSub($id)
    {
        $sub = Subcategory::findOrFail($id);
        $sub->is_active = !$sub->is_active;
        $sub->save();

        sweetalert('Subcategory Status Updated Successfully!', 'success');
       $this->dispatch('refreshTable');
    }


    public function saveBrand()
    {
        $this->validate([
            'brand_name' => 'required|string|max:255|unique:brands,name',
            'logo' => 'nullable|image|max:2048',
        ]);

        $logoPath = null;
        if ($this->logo) {
            $logoPath = $this->logo->store('brands', 'public');
        }

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
        Brand::create([
            'store_id' => $storeId,
            'created_by' => $createdBy,
            'name' => $this->brand_name,
            'slug' => Str::slug($this->brand_name),
            'logo' => $logoPath,
            'is_active' => true,
        ]);

        $this->resetForm();
        flash()->addSuccess('Brand Created Successfully!');
       $this->dispatch('refreshTable');
    }
    public $old_logo;
    public function editBrand($id)
    {
        $brand = Brand::findOrFail($id);
        $this->brand_id = $brand->id;
        $this->brand_name = $brand->name;
        $this->logo = null;
        $this->old_logo = $brand->logo;
        $this->editMode = true;
    }

    public function updateBrand()
    {
        $this->validate([
            'brand_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands', 'name')->ignore($this->brand_id),
                'logo' => $this->logo instanceof \Livewire\TemporaryUploadedFile ? 'image|max:2048' : '',
            ],
        ]);

        $brand = Brand::findOrFail($this->brand_id);

        $data = [
            'name' => $this->brand_name,
            'slug' => Str::slug($this->brand_name),
        ];

        if ($this->logo) {
            $data['logo'] = $this->logo->store('brands', 'public');
        }

        $brand->update($data);

        $this->reset(['brand_id', 'brand_name', 'logo', 'editMode', 'old_logo']);
        flash()->addSuccess('Brand Updated Successfully!');
        $this->dispatch('refreshTable');
    }


    public function triggerDeleteBrand($id)
    {
        $this->dispatch('swal:confirm', [
            'type'       => 'warning',
            'title'      => 'Are you sure?',
            'text'       => 'This Brand will be deleted permanently!',
            'id'         => $id,
            'nextAction' => 'deleteConfirmedBrand'
        ]);
    }

    #[On('deleteConfirmedBrand')]
    public function deleteConfirmedBrand($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        session()->flash('warning', 'Brand deleted successfully!');
      $this->dispatch('refreshTable');
    }

    public function triggerStatusBrand($id)
    {
        $brand = Brand::findOrFail($id);
        $statusText = $brand->is_active ? 'Inactive' : 'Active';

        $this->dispatch('swal:confirm', [
            'type'       => 'info',
            'title'      => 'Change Status?',
            'text'       => "Are you sure you want to make this brand $statusText?",
            'id'         => $id,
            'nextAction' => 'statusConfirmedBrand'
        ]);
    }

    #[On('statusConfirmedBrand')]
    public function statusConfirmedBrand($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->is_active = !$brand->is_active;
        $brand->save();

        sweetalert('Brand Status Updated Successfully!', 'success');
       $this->dispatch('refreshTable');
    }

    #[Layout('layouts.admin')]
    #[Title('Categories')]
    public function render()
    {
        abort_if(!auth()->user()->can('view stores') || !auth()->user()->can('view categories'), 403, 'You do not have permission to view this page.');
        $userId = auth()->user()->id;

        $userRoles = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_has_roles.model_id', $userId)
            ->pluck('roles.name')
            ->toArray();

        if (in_array('Admin', $userRoles)) {
            $adminId = $userId;
        } elseif (in_array('Store Manager', $userRoles)) {
            $adminId = DB::table('managers')
                ->where('user_id', $userId)
                ->value('admin_id');
        } elseif (in_array('Employee POS', $userRoles)) {
            $id = DB::table('employees')
                ->where('user_id', $userId)
                ->value('admin_id');
            $adminId = DB::table('managers')->where('user_id', $id)->value('admin_id');
        } else {
            $adminId = null;
        }

        $storeId = Store::where('admin_id', $adminId)->value('id');

        $categories = Category::where('store_id', $storeId)
            ->latest()
            ->get();
        $this->brands = Brand::where('store_id', $storeId)
            ->get();
        $subcategories = Subcategory::with('category')
            ->where('store_id', $storeId)
            ->get();

        return view('livewire.admin.categories', compact('categories', 'subcategories'));
    }
}
