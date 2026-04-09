<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Can;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Index extends Component
{

    #[Layout('layouts.admin')]
    #[Title('Orders')]

    public function updateOrderItemStatus($itemId, $status)
    {
        $item = \App\Models\OrderItem::with('product', 'order')->find($itemId);
        if (!$item) return;

        $oldStatus = $item->status;
        if ($oldStatus === $status) return;

        try {
            DB::transaction(function () use ($item, $status, $oldStatus) {
                if (in_array($status, ['Cancelled', 'Returned'])) {
                    if (!in_array($oldStatus, ['Cancelled', 'Returned'])) {
                        if ($item->product) {
                            $item->product->increment('stock', $item->qty);
                        }
                        // Cancel points specifically for this item
                        $histories = DB::table('loyalty_histories')
                            ->where('order_item_id', $item->id)
                            ->get();

                        foreach ($histories as $history) {
                            if ($history->status === 'completed') {
                                \App\Models\Customer::where('id', $history->customer_id)->decrement('loyalty_points', $history->points);
                            }
                        }

                        DB::table('loyalty_histories')
                            ->where('order_item_id', $item->id)
                            ->update(['status' => 'cancelled']);
                    }
                } elseif (in_array($oldStatus, ['Cancelled', 'Returned'])) {
                    if ($item->product) {
                        $item->product->decrement('stock', $item->qty);
                    }
                    // If moving back to an active status, we could set points back to pending
                    DB::table('loyalty_histories')
                        ->where('order_item_id', $item->id)
                        ->where('status', 'cancelled')
                        ->update(['status' => 'pending']);
                }

                if ($status === 'Delivered') {
                    $item->delivered_at = now();
                } else {
                    $item->delivered_at = null;
                }

                $item->status = $status;
                $item->save();

                // Check if all items are cancelled or returned to update order status
                $order = $item->order;
                $allItems = \App\Models\OrderItem::where('order_id', $order->id)->get();
                $statusValues = $allItems->pluck('status')->unique()->toArray();
                $activeStatuses = array_diff($statusValues, ['Cancelled', 'Returned']);

                if (empty($activeStatuses)) {
                    $order->order_status = (count($statusValues) === 1) ? $statusValues[0] : 'Cancelled';
                    $order->payment_status = 'Refunded';
                    $order->save();
                }
            });

            $this->dispatch('swal', title: 'Item status updated successfully', icon: 'success');
            $this->dispatch('refreshTable');
        } catch (\Exception $e) {
            $this->dispatch('swal', title: $e->getMessage(), icon: 'error');
        }
    }


    public function updateStatus($orderId, $status)
    {
        $order = Order::with('items.product')->find($orderId);
        if (!$order) return;

        $oldStatus = $order->order_status;
        if ($oldStatus === $status) return;

        try {
            DB::transaction(function () use ($order, $status) {
                foreach ($order->items as $item) {
                    $oldItemStatus = $item->status;

                    if (in_array($status, ['Cancelled', 'Returned'])) {

                        if (!in_array($oldItemStatus, ['Cancelled', 'Returned'])) {
                            if ($item->product) {
                                $item->product->increment('stock', $item->qty);
                            }
                        }
                    } elseif (in_array($oldItemStatus, ['Cancelled', 'Returned'])) {
                        if ($item->product) {
                            $item->product->decrement('stock', $item->qty);
                        }
                    }

                    if ($status === 'Delivered') {
                        $item->delivered_at = now();
                    } else {
                        $item->delivered_at = null;
                    }

                    $item->status = $status;
                    $item->save();
                }

                $order->order_status = $status;
                if (in_array($status, ['Cancelled', 'Returned'])) {
                    $order->payment_status = 'Refunded';

                    $histories = DB::table('loyalty_histories')
                        ->where('order_id', $order->id)
                        ->get();

                    foreach ($histories as $history) {
                        if ($history->status === 'completed') {
                            \App\Models\Customer::where('id', $history->customer_id)->decrement('loyalty_points', $history->points);
                        }
                    }

                    DB::table('loyalty_histories')
                        ->where('order_id', $order->id)
                        ->update(['status' => 'cancelled']);
                }

                $order->save();
            });

            $this->dispatch('swal', title: 'Order updated successfully', icon: 'success');
            $this->dispatch('refreshTable');
        } catch (\Exception $e) {
            $this->dispatch('swal', title: $e->getMessage(), icon: 'error');
        }
    }

    public function updatePaymentStatus($orderId, $status)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->payment_status = $status;
            $order->save();
            sweetalert('Payment status updated successfully!', 'success');
            $this->dispatch('refreshTable');
        }
    }

    public function render()
    {
        abort_if(!auth()->user()->can('view orders'), 403, 'You do not have permission to view this page.');
        $user = auth()->user();
        $query = Order::query();

        if ($user->hasRole('Store Manager')) {
            $manager = \App\Models\Manager::where('user_id', $user->id)->first();
            if ($manager) {
                $query->where('store_id', $manager->store_id);
            }
        } elseif ($user->hasRole('Employee POS')) {
            $employee = \App\Models\Employee::where('user_id', $user->id)->first();
            if ($employee) {
                $query->where('store_id', $employee->store_id);
            }
        } elseif ($user->hasRole('Admin')) {
            $admin = \App\Models\store::where('admin_id', $user->id)->first();
            if ($admin) {
                $query->where('store_id', $admin->id);
            }
        }

        $orders = $query->with('items.product')->orderBy("order_type", "asc")->orderBy('created_at', 'desc')->get();
        return view('livewire.admin.orders.index', compact('orders'));
    }
}
