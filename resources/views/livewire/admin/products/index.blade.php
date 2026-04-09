<div class="card p-3">
    @can('create products')
    <div class="card card-outline {{ $editMode ? 'card-warning' : 'card-primary' }} mb-4 shadow-sm">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title fw-bold">
                    <i class="fas {{ $editMode ? 'fa-edit' : 'fa-plus-circle' }} me-2 {{ $editMode ? 'text-warning' : 'text-primary' }}"></i>
                    {{ $editMode ? 'Edit Product' : 'Add New Product' }}
                </h3>
                @if($editMode)
                <button wire:click="resetForm" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back to Create
                </button>
                @endif
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold">Product Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"> <i class="fas fa-box text-muted"></i> </span>
                            <input type="text" wire:model="name" class="form-control border-start-0 ps-1 @error('name') is-invalid @enderror" placeholder="Enter product name">
                        </div>
                        @error('name') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label fw-bold">Selling Price (₹)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-tag text-muted"></i>
                            </span>
                            <input type="number" wire:model="price" class="form-control border-start-0 ps-1 @error('price') is-invalid @enderror" placeholder="0.00">
                        </div>
                        @error('price') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label fw-bold">MRP / Discount Price (₹)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-rupee-sign text-muted"></i>
                            </span>
                            <input type="number" wire:model="discount_price" class="form-control border-start-0 ps-1 @error('discount_price') is-invalid @enderror" placeholder="0.00">
                        </div>
                        <div class="form-text small text-muted">The price that needs to be shown</div>
                        @error('discount_price') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-6 col-md-4">
                        <label class="form-label fw-bold">Stock Qty</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-cubes text-muted"></i>
                            </span>
                            <input type="number" wire:model="stock" class="form-control border-start-0 ps-1" placeholder="0">
                        </div>
                        @error('stock') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-6 col-md-4">
                        <label class="form-label fw-bold">
                            Delivery Charge
                            <small class="text-muted fw-normal" style="font-size: 11px;">(If free then enter 0)</small>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-shipping-fast text-muted"></i>
                            </span>
                            <input type="number" wire:model="delivery_charge" class="form-control border-start-0 ps-1" placeholder="0">
                        </div>
                        @error('delivery_charge') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-6 col-md-4">
                        <label class="form-label fw-bold">
                            Return Policy Days
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-calendar-alt text-muted"></i>
                            </span>
                            <input type="number" wire:model="return_policy_days" class="form-control border-start-0 ps-1" placeholder="0">
                        </div>
                        @error('return_policy_days') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label fw-bold">Brand</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-box text-muted"></i>
                            </span>
                            <select wire:model.live="brand_id" class="form-select border-start-0 ps-1">
                                <option value="">-- Select Brand --</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('brand') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-bold">Category</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-folder text-muted"></i>
                            </span>
                            <select wire:model.live="category_id" class="form-select border-start-0 ps-1">
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12 col-md-4" wire:key="subcategory-wrapper-{{ $productId }}"> <label class="form-label fw-bold">Subcategory</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-folder-open text-muted"></i>
                            </span>
                            <select wire:model="subcategory_id" class="form-select border-start-0 ps-1" wire:key="sub-select-{{ $productId }}">
                                <option value="">-- Select Subcategory --</option>
                                @foreach($subcategories as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('subcategory_id') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold">Main Image</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-image text-muted"></i>
                            </span>
                            <input type="file" wire:model="main_image" class="form-control border-start-0 ps-1" accept="image/*">
                        </div>

                        <div wire:loading wire:target="main_image" class="text-primary small mt-1">
                            <i class="fas fa-spinner fa-spin me-1"></i> Uploading...
                        </div>

                        <div class="mt-2">
                            @if ($main_image && !is_string($main_image))
                            <img src="{{ $main_image->temporaryUrl() }}" class="img-thumbnail shadow-sm border-primary" style="height: 80px; width: 80px; object-fit: cover;">
                            @elseif($old_main_image)
                            <img src="{{ asset('storage/'.$old_main_image) }}" class="img-thumbnail shadow-sm" style="height: 80px; width: 80px; object-fit: cover;">
                            @endif
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold">Gallery Images</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-images text-muted"></i>
                            </span>
                            <input type="file" wire:model="gallery_images" class="form-control border-start-0 ps-1" multiple accept="image/*">
                        </div>

                        <div wire:loading wire:target="gallery_images" class="text-primary small mt-1">
                            <i class="fas fa-spinner fa-spin me-1"></i> Uploading Gallery...
                        </div>

                        <div class="d-flex mt-2 gap-2 flex-wrap">
                            @if ($gallery_images)
                            @foreach($gallery_images as $index => $img)
                            <div class="position-relative" wire:key="new-img-{{ $index }}">
                                <img src="{{ $img->temporaryUrl() }}" class="img-thumbnail shadow-sm" style="height: 60px; width: 60px; object-fit: cover; border: 2px solid #0d6efd;">

                                <button type="button"
                                    wire:click="removeSelectedImage({{ $index }})"
                                    class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle rounded-circle shadow"
                                    style="width: 22px; height: 22px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-times" style="font-size: 10px;"></i>
                                </button>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        @if($editMode && count($existing_gallery) > 0)
                        <div class="mt-3 border-top pt-2">
                            <p class="small text-muted mb-2"><i class="fas fa-history me-1"></i> Current Gallery Images:</p>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach($existing_gallery as $g_img)
                                <div class="position-relative">
                                    <img src="{{ asset('storage/'.$g_img->image_path) }}" class="img-thumbnail shadow-sm" style="height: 50px; width: 50px; object-fit: cover;">
                                    <button type="button"
                                        wire:click="deleteGalleryImage({{ $g_img->id }})"
                                        wire:confirm="Are you sure you want to delete this image?"
                                        class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle rounded-circle shadow"
                                        style="width: 22px; height: 22px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-times" style="font-size: 10px;"></i>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>


                    <div class="col-12 mb-4">
                        <label class="form-label fw-bold">Product Sort Description</label>
                        <div wire:ignore>
                            <textarea id="sort_editor" rows="4" placeholder="Sort Description Here" wire:model.defer="sort_description" class="form-control">{!! $sort_description !!}</textarea>
                        </div>
                        @error('sort_description') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>


                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Product Brief Description (Specifications)</label>
                        <div wire:ignore>
                            <textarea id="full_editor"></textarea>
                        </div>
                        @error('description') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror

                        <style>
                            .ck-editor__editable_inline {
                                min-height: 300px;
                            }
                        </style>
                        <div class="form-text small text-muted">
                            <i class="fas fa-info-circle me-1"></i> Briefly describe your product for the customers.
                        </div>
                    </div>

                    <div class="col-12 text-end mt-3 border-top pt-3">
                        @if($editMode)
                        <button type="button" wire:click="resetForm" class="btn btn-secondary me-2">Cancel</button>
                        @can('edit products')
                        <button type="submit" class="btn btn-warning px-4 text-white">Update Product</button>
                        @endcan
                        @else
                        <button type="submit" class="btn btn-primary px-4">Save Product</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
    @else
    <div class="alert alert-info shadow-sm"><i class="fas fa-info-circle me-2"></i> You don't have permission to create products.</div>
    @endcan
    <div class="card card-outline card-info shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title fw-bold">Product List</h3>
        </div>
        <div class="card-body p-2 mt-2" wire:ignore>
            <div class="table-responsive">
                <table id="dataTable" class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Image</th>
                            <th>Product Details</th>
                            <th>Category</th>
                            <th>Price & Stock</th>
                            <th>Status</th>
                            <th class="text-end" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                        <tr wire:key="product-row-{{ $p->id }}">
                            <td>
                                <img src="{{ asset('storage/'.$p->image) }}" class="rounded shadow-sm border" width="50" height="50" style="object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ Str::limit($p->name, 30) }}</div>
                                <small class="text-muted">SKU: {{ $p->sku }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $p->category->name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-primary">₹{{ number_format($p->price) }}</div>
                                <span class="badge {{ $p->stock > 10 ? 'text-success' : 'text-danger' }} p-0" style="font-size: 11px;">
                                    {{ $p->stock > 0 ? 'Stock: '.$p->stock : 'Out of Stock' }}
                                </span>
                            </td>
                            <td>
                                @can('edit products')
                                <button type="button" wire:click="toggleStatus('{{ $p->id }}')"
                                    class="border-0 badge {{ $p->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill" style="cursor: pointer;">
                                    {{ $p->is_active ? 'Active' : 'Inactive' }}
                                </button>
                                @else
                                <span class="badge {{ $p->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                    {{ $p->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @endcan
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    @can('edit products')
                                    <button wire:click="edit('{{ $p->id }}')"
                                        onclick="window.scrollTo({top: 0, behavior: 'smooth'});"
                                        class="btn btn-outline-warning border-0"
                                        title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    @endcan
                                    @can('delete products')
                                    <button wire:click="triggerDelete('{{ $p->id }}')" class="btn btn-outline-danger border-0" title="Delete">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                No Products Found. Start by adding one!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    let editorInstance;

    function initCKEditor() {
        const editorElement = document.querySelector('#full_editor');
        if (!editorElement) return;

        if (editorInstance) {
            editorInstance.destroy()
                .then(() => {
                    createEditor(editorElement);
                })
                .catch(error => console.error(error));
        } else {
            createEditor(editorElement);
        }
    }

    function createEditor(element) {
        ClassicEditor
            .create(element, {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
            })
            .then(editor => {
                editorInstance = editor;

                editor.model.document.on('change:data', () => {
                    @this.set('description', editor.getData(), false);
                });

                let existingData = @this.get('description');
                if (existingData) {
                    editor.setData(existingData);
                }
            })
            .catch(error => console.error(error));
    }

    document.addEventListener('DOMContentLoaded', initCKEditor);
    document.addEventListener('livewire:initialized', () => {
        Livewire.hook('morph.updated', ({
            el,
            component
        }) => {
            if (!editorInstance && document.querySelector('#full_editor')) {
                initCKEditor();
            }
        });
    });

    window.addEventListener('update-editor-content', event => {
        const content = event.detail.content !== undefined ? event.detail.content : event.detail[0].content;
        if (editorInstance) {
            editorInstance.setData(content || '');
        } else {
            setTimeout(() => {
                if (editorInstance) editorInstance.setData(content || '');
            }, 500);
        }
    });
</script>
@endpush