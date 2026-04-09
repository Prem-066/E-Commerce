<?php

namespace App\Livewire\Admin\Coupons;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Coupon;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    #[Layout('layouts.admin')]
    #[Title('Coupons Management')]

    public $search = '';
    public $couponId;
    public $code, $description, $discount_type = 'percentage', $discount_value, $min_order_amount, $max_discount, $valid_from, $valid_until, $usage_limit, $is_active = true;

    protected $rules = [
        'code' => 'required|string|max:255',
        'description' => 'required|string',
        'discount_type' => 'required|in:percentage,fixed',
        'discount_value' => 'required|numeric|min:0',
        'min_order_amount' => 'nullable|numeric|min:0',
        'max_discount' => 'nullable|numeric|min:0',
        'valid_from' => 'required|date',
        'valid_until' => 'required|date|after_or_equal:valid_from',
        'usage_limit' => 'nullable|integer|min:0',
        'is_active' => 'boolean',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['couponId', 'code', 'description', 'discount_type', 'discount_value', 'min_order_amount', 'max_discount', 'valid_from', 'valid_until', 'usage_limit', 'is_active']);
        $this->discount_type = 'percentage';
        $this->is_active = true;
        $this->dispatch('showModal');
    }

    public function editCoupon($id)
    {
        $this->resetValidation();
        $coupon = Coupon::findOrFail($id);
        $this->couponId = $coupon->id;
        $this->code = $coupon->code;
        $this->description = $coupon->description;
        $this->discount_type = $coupon->discount_type;
        $this->discount_value = $coupon->discount_value;
        $this->min_order_amount = $coupon->min_order_amount;
        $this->max_discount = $coupon->max_discount;
        $this->valid_from = $coupon->valid_from ? $coupon->valid_from->format('Y-m-d') : '';
        $this->valid_until = $coupon->valid_until ? $coupon->valid_until->format('Y-m-d') : '';
        $this->usage_limit = $coupon->usage_limit;
        $this->is_active = $coupon->is_active;

        $this->dispatch('showModal');
    }

    public function saveCoupon()
    {
        $rules = $this->rules;
        if ($this->couponId) {
            $rules['code'] = 'required|string|max:255|unique:coupons,code,' . $this->couponId;
        } else {
            $rules['code'] = 'required|string|max:255|unique:coupons,code';
        }

        $this->validate($rules);

        Coupon::updateOrCreate(['id' => $this->couponId], [
            'code' => $this->code,
            'description' => $this->description,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'min_order_amount' => $this->min_order_amount,
            'max_discount' => $this->max_discount,
            'valid_from' => $this->valid_from,
            'valid_until' => $this->valid_until,
            'usage_limit' => $this->usage_limit,
            'is_active' => $this->is_active,
        ]);

        $this->dispatch('hideModal');

        flash()->addSuccess($this->couponId ? 'Coupon updated successfully!' : 'Coupon created successfully!');
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'nextAction' => 'deleteCoupon'
        ]);
    }

    #[On('deleteCoupon')]
 
     public function deleteCoupon($id)
    {
        Coupon::find($id)?->delete();
        sweetalert('Coupon deleted Successfully !', 'warning');

    }

    public function toggleStatus($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update(['is_active' => !$coupon->is_active]);
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Status updated!'
        ]);
    }

    public function render()
    {
        $coupons = Coupon::where(function ($query) {
            $query->where('code', 'LIKE', '%' . $this->search . '%')
                ->orWhere('description', 'LIKE', '%' . $this->search . '%');
        })
            ->latest()
            ->paginate(12);

        return view('livewire.admin.coupons.index', compact('coupons'));
    }
}
