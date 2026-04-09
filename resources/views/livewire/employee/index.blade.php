<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-dark">
            <i class="fas fa-boxes text-primary me-2"></i> Inventory Stock
        </h5>
    </div>

    <div class="card-body p-2 mt-2" wire:ignore>
        <div class="table-responsive">
            <table id="dataTable" class="table align-middle table-hover mb-0">
                <thead class="table-light">
                    <tr class="text-uppercase small fw-bold">
                        <th class="ps-4">Product Details</th>
                        <th>Category</th>
                        <th class="text-center">Current Stock</th>
                        <th class="text-end">Selling Price</th>
                        <th class="text-center pe-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded me-3" style="width: 50px; height: 50px; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 1px solid #eee;">
                                    @if($product->image && file_exists(public_path('storage/' . $product->image)))
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                    <i class="fas fa-image text-muted fs-4"></i>
                                    @endif
                                </div>

                                <div>
                                    <div class="fw-bold text-dark mb-1" style="max-width: 450px; line-height: 1.3; word-wrap: break-word;">
                                        {{ $product->name }}
                                    </div>

                                    <small class="text-muted d-block" style="max-width: 450px; line-height: 1.2; word-wrap: break-word; font-family: monospace; background: #f8f9fa; padding: 2px 5px; border-radius: 4px;">
                                        <span class="fw-semibold">SKU:</span> {{ $product->sku ?? 'N/A' }}
                                    </small>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex flex-column gap-1">
                                <div>
                                    <span class="badge rounded-pill fw-medium px-3 py-2"
                                        style="background-color: rgba(13, 202, 240, 0.15); color: #087990; border: 1px solid rgba(13, 202, 240, 0.3);">
                                        <i class="fas fa-tag small me-1"></i>
                                        {{ $product->category?->name ?? 'General' }}
                                    </span>
                                </div>

                                @if($product->subcategory)
                                <div class="small text-muted d-flex align-items-center ms-2" style="font-size: 0.75rem;">
                                    <i class="fas fa-level-up-alt fa-rotate-90 me-2 opacity-50"></i>
                                    <span class="fw-normal">{{ $product->subcategory->name }}</span>
                                </div>
                                @else
                                <div class="small text-muted ms-2 opacity-50" style="font-size: 0.75rem; font-style: italic;">
                                    No subcategory
                                </div>
                                @endif
                            </div>
                        </td>

                        <td class="text-center">
                            <span class="fw-bold {{ $product->stock <= 20 ? 'text-danger' : 'text-dark' }}">
                                {{ $product->stock }} Items
                            </span>
                        </td>

                        <td class="text-end">
                            <div class="fw-bold text-success">
                                <i class="fa fa-inr me-1" style="font-size: 0.8rem;"></i>
                                {{ number_format($product->price, 2) }}
                            </div>
                        </td>

                        <td class="text-center pe-4">
                            @if($product->stock <= 0)
                                <span class="badge bg-danger rounded-pill px-3 py-2">Out of Stock</span>
                                @elseif($product->stock <= 20)
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Low Stock</span>
                                    @else
                                    <span class="badge bg-success rounded-pill px-3 py-2">Full Stock</span>
                                    @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-3x mb-3 opacity-25"></i>
                            <p>No products found in your store's inventory.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>