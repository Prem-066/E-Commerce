<div class="container-fluid py-4">
    <form wire:submit.prevent="save">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-purple card-outline mb-4 border-top-primary">
                    <div class="card-header">
                        <h3 class="card-title text-purple"><i class="fas fa-trophy me-2"></i> Earning & Redemption</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-4 p-3 border rounded bg-light d-flex justify-content-between align-items-center">
                            <label class="form-check-label fw-bold">Enable Loyalty Program</label>
                            <input class="form-check-input scale-150" type="checkbox" wire:model="enable_loyalty">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Points Per ₹100 Spent</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-coins text-warning"></i></span>
                                <input type="number" wire:model="points_per_hundred" class="form-control border-start-0 ps-1">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">1 Point Value (in ₹)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-hand-holding-usd text-success"></i></span>
                                <input type="number" step="0.01" wire:model="point_value_in_currency" class="form-control border-start-0 ps-1">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Minimum Points to Redeem</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                <input type="number" wire:model="min_redeem_points" class="form-control border-start-0 ps-1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-info card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title text-info"><i class="fas fa-users me-2"></i> Referral Rewards</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-600">Referrer Bonus (Points)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user-plus text-info"></i></span>
                                <input type="number" wire:model="referrer_reward_points" class="form-control border-start-0 ps-1">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Referee Welcome Bonus (Points)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-gift text-danger"></i></span>
                                <input type="number" wire:model="referee_reward_points" class="form-control border-start-0 ps-1">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                        <i class="fas fa-save me-2"></i> Update Loyalty Settings
                    </button>
                </div>
            </div>
        </div>
    </form>
    <style>
        .card-purple {
            border-top: 3px solid #6f42c1;
        }

        .text-purple {
            color: #6f42c1;
        }

        .scale-150 {
            transform: scale(1.5);
            cursor: pointer;
        }
    </style>
    <style>
        .loyalty-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .loyalty-table thead {
            background-color: #f8f9fa;
        }

        .loyalty-table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-bottom-width: 1px;
        }

        .point-badge {
            font-size: 0.9rem;
            padding: 5px 12px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            font-weight: 700;
        }

        .earned-points {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .redeemed-points {
            background-color: #ffebee;
            color: #c62828;
        }

        .customer-avatar {
            width: 32px;
            height: 32px;
            background: #eef2ff;
            color: #4f46e5;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 0.8rem;
        }
    </style>

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card loyalty-card">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="fas fa-history me-2 text-primary"></i> Transactions Log
                    </h5>
                    <span class="badge bg-primary-subtle text-primary border px-3 py-2 rounded-pill">
                        {{ $loyaltyHistory->count() }} Records Total
                    </span>
                </div>
                <div class="card-body p-2 mt-2">
                    <div class="table-responsive" wire:ignore>
                        <table id="dataTable" class="table table-hover align-middle mb-0 loyalty-table">
                            <thead>
                                <tr>
                                    <th class="ps-4">Date & Time</th>
                                    <th>Customer</th>
                                    <th>Reference</th>
                                    <th class="text-center">Points</th>
                                    <th>Action Type</th>
                                    <th class="pe-4">Activity Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($loyaltyHistory as $history)
                                <tr wire:key="loyalty-{{ $history->id }}">
                                    <td class="ps-4">
                                        <div class="d-flex flex-column">
                                            <span class="text-dark fw-500">{{ $history->created_at ? $history->created_at->format('d M, Y') : 'N/A' }}</span>
                                            <small class="text-muted">{{ $history->created_at ? $history->created_at->format('h:i A') : '' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="customer-avatar me-2">
                                                {{ strtoupper(substr($history->customer->first_name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-dark">{{ $history->customer->first_name . ' ' . $history->customer->last_name ?? 'Unknown Customer' }}</span>
                                                <small class="text-muted">{{ $history->customer->phone ?? 'No Phone' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-primary border py-2 px-3 fw-normal" style="font-family: monospace;">
                                            <i class="fas fa-file-invoice me-1 small"></i>ORDER-{{ $history->order_id }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="point-badge {{ $history->type == 'earned' ? 'earned-points' : 'redeemed-points' }}">
                                            <i class="fas {{ $history->type == 'earned' ? 'fa-plus-circle' : 'fa-minus-circle' }} me-1 small"></i>
                                            {{ $history->points }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($history->type == 'earned')
                                        <span class="badge bg-success text-white px-3 py-2 rounded-pill">
                                            <i class="fas fa-arrow-up me-1 small"></i> Earned
                                        </span>
                                        @else
                                        <span class="badge bg-danger text-white px-3 py-2 rounded-pill">
                                            <i class="fas fa-arrow-down me-1 small"></i> Redeemed
                                        </span>
                                        @endif
                                    </td>
                                    <td class="pe-4">
                                        <p class="mb-0 text-dark small" style="max-width: 250px;">
                                            {{ $history->description }}
                                        </p>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-folder-open text-muted mb-3" style="font-size: 3rem;"></i>
                                            <h6 class="text-muted">No transactions found yet</h6>
                                            <p class="small text-muted mb-0">Reward activities will appear here once customers start earning points.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($loyaltyHistory->count() > 10)
                <div class="card-footer bg-white py-3 border-top-0">
                    <p class="text-muted small mb-0 text-center italic">
                        <i class="fas fa-info-circle me-1"></i> Showing latest reward activities. Use the search bar above to filter results.
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>