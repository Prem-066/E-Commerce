<div class="container-fluid pt-4">
    <div class="row g-3">
        <div class="col-md-2">
            <button class="btn btn-dark w-100 d-md-none mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#mobileFilters">
                <i class="bi bi-funnel"></i> Show/Hide Filters
            </button>

            <div class="collapse d-md-block sticky-top" id="mobileFilters" style="top: 20px;">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white fw-bold d-none d-md-block">Report Filters</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="small fw-bold">Date Range</label>
                            <div class="row g-2">
                                <div class="col-6 col-md-12">
                                    <input type="date" wire:model.live="startDate" class="form-control form-control-sm">
                                </div>
                                <div class="col-6 col-md-12">
                                    <input type="date" wire:model.live="endDate" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold">Staff / Personnel</label>
                            <select wire:model.live="selectedUser" class="form-select form-select-sm">
                                <option value="">All Personnel</option>
                                @foreach($allUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-10">
            <div class="row g-3 mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-success shadow-sm border-0 h-100">
                        <div class="inner"> 
                            <h3>₹{{ number_format($totalRevenue, 0) }}</h3>
                            <p>Total Revenue</p>
                        </div>
                        <div class="small-box-icon">
                            <i class="bi bi-currency-rupee"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-info shadow-sm border-0 h-100">
                        <div class="inner">
                            <h3>{{ $totalOrders }}</h3>
                            <p>Total Orders</p>
                        </div>
                        <div class="small-box-icon">
                            <i class="bi bi-cart-check"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-warning shadow-sm border-0 h-100 text-white">
                        <div class="inner">
                            <h3>₹{{ number_format($cashSales, 0) }}</h3>
                            <p>Cash Sales</p>
                        </div>
                        <div class="small-box-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-primary shadow-sm border-0 h-100">
                        <div class="inner">
                            <h3>₹{{ number_format($onlineSales, 0) }}</h3>
                            <p>Online Sales</p>
                        </div>
                        <div class="small-box-icon">
                            <i class="bi bi-credit-card"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-hover align-middle mb-0 text-nowrap">
                            <thead class="bg-light small text-uppercase fw-bold">
                                <tr>
                                    <th>Order #</th>
                                    <th>Date/Time</th>
                                    <th>Customer Details</th>
                                    <th>Handled By</th>
                                    <th class="text-end">Amount</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @forelse($reports as $order)
                                <tr wire:key="order-{{ $order->id }}">
                                    <td>
                                        <span class="fw-bold text-dark" style="font-size:12px;">
                                            @if($order->order_number)
                                            #{{ $order->order_number }}
                                            @else
                                            #{{ strtoupper(substr($order->id, 0, 8)) }}
                                            @endif
                                        </span>
                                    </td>
                                    <td data-order="{{ $order->created_at->timestamp }}">{{ $order->created_at->format('d/m/y | h:i A') }}</td>

                                    <td>
                                        <div class="fw-bold text-dark text-capitalize">{{ $order->customer_name ?: 'Walk-in Customer' }}</div>
                                        @if($order->customer_phone)
                                        <small class="text-muted "><i class="bi bi-telephone" style="font-size: 10px;"></i> {{ $order->customer_phone }}</small>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="fw-bold text-primary">{{ $order->employee->name ?? 'Admin' }}</div>
                                    </td>
                                    <td class="text-end fw-bold">₹{{ number_format($order->total_amount, 2) }}</td>
                                    <td class="text-center">
                                        @php
                                        $oStatus = $order->order_status ?? $order->status ?? 'pending';
                                        $badgeColor = match(strtolower($oStatus)) {
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                        'returned' => 'secondary',
                                        'processing' => 'info',
                                        'out for delivery', 'shipping' => 'warning',
                                        default => 'secondary'
                                        };
                                        @endphp
                                        <span class="badge rounded-pill bg-{{ $badgeColor }}">
                                            {{ ucfirst($oStatus) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button wire:click="viewOrderDetails('{{ $order->id }}')" class="btn btn-sm btn-outline-primary border-1 shadow-none">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">No records found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="orderDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                @if($selectedOrder)
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">Order Details #{{ strtoupper(substr($selectedOrder->id, 0, 8)) }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between mb-3 bg-light p-2 rounded">
                        <div>
                            <small class="text-muted d-block">Handled By</small>
                            <span class="fw-bold">{{ $selectedOrder->employee->name ?? 'Admin' }}</span>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block">Date</small>
                            <span class="fw-bold">{{ $selectedOrder->created_at->format('d M, Y h:i A') }}</span>
                        </div>
                    </div>

                    <table id="modalTable" class="table table-sm border-bottom">
                        <thead>
                            <tr class="small text-muted">
                                <th>Item Name</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($selectedOrder->items as $item)
                            <tr class="small">
                                <td>{{ $item->product->name }}</td>
                                <td class="text-center">{{ $item->qty }}</td>
                                <td class="text-end">₹{{ number_format($item->qty * $item->price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between h5 mt-3">
                        <span class="fw-bold">Grand Total:</span>
                        <span class="fw-bold text-success">₹{{ number_format($selectedOrder->total_amount, 2) }}</span>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        window.addEventListener('openModal', event => {
            var modalElement = document.getElementById('orderDetailModal');
            var myModal = new bootstrap.Modal(modalElement);
            myModal.show();
            modalElement.addEventListener('shown.bs.modal', function() {
                if ($.fn.DataTable.isDataTable('#modalTable')) {
                    $('#modalTable').DataTable().destroy();
                }

                $('#modalTable').DataTable({
                    "paging": false, 
                    "searching": false,
                    "info": false,
                    "ordering": true
                });
            }, {
                once: true
            }); 
        });
    </script>
    <script>
        function initDataTable() {
            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().destroy();
            }

            $('#dataTable').DataTable({
                "pageLength": 10,
                "order": [[1, 'desc']],
                "retrieve": true,
                "responsive": false,
                "dom": '<"d-flex justify-content-between align-items-center mb-3"lBf>rtip',
                "buttons": [{
                        extend: 'excelHtml5',
                        className: 'btn btn-success btn-sm mx-1',
                        text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-danger btn-sm mx-1',
                        text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-info btn-sm mx-1 text-white',
                        text: '<i class="bi bi-printer"></i> Print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }
                ],
                "language": {
                    "search": "Search:",
                    "lengthMenu": "_MENU_ entries"
                }
            });
        }

        $(document).ready(function() {
            setTimeout(initDataTable, 100);
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('refreshDataTable', () => {
                setTimeout(() => {
                    initDataTable();
                }, 250);
            });
        });
    </script>
    @endpush
</div>