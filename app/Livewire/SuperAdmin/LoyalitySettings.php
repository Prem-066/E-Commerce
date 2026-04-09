<?php

namespace App\Livewire\SuperAdmin;

use App\Models\LoyaltyHistory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\LoyaltySetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoyalitySettings extends Component
{
    public $enable_loyalty, $points_per_hundred, $point_value_in_currency;
    public $min_redeem_points, $referrer_reward_points, $referee_reward_points;

    public function mount()
    {
        $settings = LoyaltySetting::first();

        if ($settings) {
            $this->fill($settings->toArray());

            $this->enable_loyalty = (bool) $settings->enable_loyalty;
        } else {
            $this->enable_loyalty = false;
            $this->points_per_hundred = 10;
            $this->point_value_in_currency = 1.00;
        }
    }

    public function save()
    {
        $this->validate([
            'enable_loyalty'          => 'boolean',
            'points_per_hundred'      => 'required|integer|min:0',
            'point_value_in_currency' => 'required|numeric|min:0',
            'min_redeem_points'       => 'required|integer|min:0',
            'referrer_reward_points'  => 'required|integer|min:0',
            'referee_reward_points'   => 'required|integer|min:0',
        ]);

        LoyaltySetting::updateOrCreate(
            ['id' => 1],
            [
                'user_id'                 => Auth::id(),
                'enable_loyalty'          => $this->enable_loyalty,
                'points_per_hundred'      => $this->points_per_hundred,
                'point_value_in_currency' => $this->point_value_in_currency,
                'min_redeem_points'       => $this->min_redeem_points,
                'referrer_reward_points'  => $this->referrer_reward_points,
                'referee_reward_points'   => $this->referee_reward_points,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]
        );

        flash()->addSuccess('Loyalty settings updated successfully!');
    }
    #[Layout('layouts.admin')]
    #[Title('Users')]
    public function render()
    {
        $loyaltyHistory = LoyaltyHistory::with('customer')->latest()->get();
        return view('livewire.super-admin.loyality-settings', compact('loyaltyHistory'));
    }
}
