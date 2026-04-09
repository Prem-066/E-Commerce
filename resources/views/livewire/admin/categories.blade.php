<div class="card p-3 border-0">
    <div class="card card-outline card-primary mb-4 shadow-sm">
        <div class="card-header bg-white">
            <div class="container-fluid p-0">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3 class="card-title fw-bold mb-0">
                            <i class="bi bi-shop me-2"></i> Manage Shop
                        </h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end mb-0 bg-transparent">
                            <li class="breadcrumb-item"><a wire:navigate href="{{ route('admin.dashboard') }}" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <ul class="nav nav-pills d-flex flex-nowrap" id="categoryTab" role="tablist">
            <li class="nav-item flex-grow-1 flex-sm-grow-0 me-2" role="presentation">
                <button class="nav-link {{ $activeTab == 'category' ? 'active shadow-sm fw-bold' : 'bg-light text-dark' }} w-100"
                    wire:click="$set('activeTab','category')" type="button">
                    <i class="bi bi-grid me-1"></i> Main Categories
                </button>
            </li>
            <li class="nav-item flex-grow-1 flex-sm-grow-0" role="presentation">
                <button class="nav-link {{ $activeTab == 'subcategory' ? 'active shadow-sm fw-bold' : 'bg-light text-dark' }} w-100"
                    wire:click="$set('activeTab','subcategory'); $wire.resetForm()" type="button">
                    <i class="bi bi-list-nested me-1"></i> Subcategories
                </button>
            </li>
            <li class="nav-item flex-grow-1 flex-sm-grow-0" role="presentation">
                <button class="nav-link {{ $activeTab == 'brands' ? 'active shadow-sm fw-bold' : 'bg-light text-dark' }} w-100"
                    wire:click="$set('activeTab','brands'); $wire.resetForm()" type="button">
                    <i class="bi bi-list-nested me-1"></i> Brands
                </button>
            </li>
        </ul>
    </div>

    <div>
        @if($activeTab == 'category')
        {{-- Main Category Tab --}}
        @if(auth()->user()->can('manage categories') || auth()->user()->can('create categories'))
        <div class="card card-outline {{ $editMode ? 'card-warning' : 'card-primary' }} mb-4 shadow-sm">
            <div class="card-header">
                <h3 class="card-title fw-bold">
                    <i class="bi {{ $editMode ? 'bi-pencil-square' : 'bi-plus-circle' }} me-2"></i>
                    {{ $editMode ? 'Edit Category' : 'Add New Category' }}
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Category Name</label>
                        <div class="d-flex flex-column flex-md-row gap-2">
                            <div class="flex-grow-1">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-tag text-muted"></i></span>
                                    <input type="text" wire:model="name" class="form-control border-start-0 ps-1" placeholder="Enter Category Name">
                                </div>
                                @error('name') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            </div>
                            <div class="d-flex gap-2">
                                @if($editMode)
                                @if(auth()->user()->can('manage categories') || auth()->user()->can('edit categories'))
                                <button wire:click="update" class="btn btn-warning px-4">
                                    <i class="bi bi-check-circle me-1"></i> Update
                                </button>
                                @endif
                                <button wire:click="resetForm" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </button>
                                @else
                                <button wire:click="save" class="btn btn-primary px-4">
                                    <i class="bi bi-save me-1"></i> Save
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="card card-outline card-info shadow-sm">
            <div class="card-header">
                <h3 class="card-title fw-bold">Category List</h3>
            </div>
            <div class="card-body p-2 mt-2">
                <div class="table-responsive">
                    <table wire:key="category-{{ now() }}" id="categoryTable" class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Name</th>
                                <th>Status</th>
                                <th class="text-end pe-3" style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td class="fw-bold ps-3 text-dark">{{ $category->name }}</td>
                                <td>
                                    @if(auth()->user()->can('manage categories') || auth()->user()->can('edit categories'))
                                    <button type="button" wire:click="triggerStatus('{{ $category->id }}', {{ $category->is_active ? 'false' : 'true' }})"
                                        class="border-0 badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                    @else
                                    <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group">
                                        @if(auth()->user()->can('manage categories') || auth()->user()->can('edit categories'))
                                        <button wire:click="edit('{{ $category->id }}')" class="btn btn-outline-warning border-0">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        @endif
                                        @if(auth()->user()->can('manage categories') || auth()->user()->can('delete categories'))
                                        <button wire:click="triggerDelete('{{ $category->id }}')" class="btn btn-outline-danger border-0">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">No Categories Found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @elseif($activeTab == 'subcategory')
        {{-- Subcategory Tab --}}
        @if(auth()->user()->can('manage subcategories') || auth()->user()->can('create subcategories'))
        <div class="card card-outline {{ $editMode ? 'card-warning' : 'card-success' }} mb-4 shadow-sm">
            <div class="card-header">
                <h3 class="card-title fw-bold">
                    <i class="bi {{ $editMode ? 'bi-pencil-square' : 'bi-plus-circle' }} me-2"></i>
                    {{ $editMode ? 'Edit Subcategory' : 'Add New Subcategory' }}
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Main Category</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-list-ul text-muted"></i></span>
                            <select wire:model="category_id" class="form-select border-start-0 ps-1 @error('category_id') is-invalid @enderror">
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-5">
                        <label class="form-label fw-bold">Subcategory Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-pencil-alt text-muted"></i></span>
                            <input type="text" wire:model="sub_name" class="form-control border-start-0 ps-1 @error('sub_name') is-invalid @enderror" placeholder="Enter Subcategory Name">
                        </div>
                        @error('sub_name') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <div class="d-flex gap-2 w-100">
                            @if($editMode)
                            @if(auth()->user()->can('manage subcategories') || auth()->user()->can('edit subcategories'))
                            <button wire:click="updateSub" class="btn btn-warning flex-grow-1">Update</button>
                            @endif
                            <button wire:click="resetForm" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i></button>
                            @else
                            <button wire:click="saveSub" class="btn btn-success w-100">Save Subcategory</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif


        <div class="card card-outline card-info shadow-sm">
            <div class="card-header">
                <h3 class="card-title fw-bold">Subcategory List</h3>
            </div>
            <div class="card-body p-2 mt-2">
                <div class="table-responsive">
                    <table id="subcategoryTable" class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Subcategory Name</th>
                                <th class="d-none d-md-table-cell">Main Category</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subcategories as $sub)
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-bold text-dark">{{ $sub->name }}</div>
                                    <div class="d-md-none small text-muted"><i class="bi bi-tags me-1"></i> {{ $sub->category->name }}</div>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <span class="badge bg-light text-dark border px-2 py-1">{{ $sub->category->name }}</span>
                                </td>
                                <td>
                                    @if(auth()->user()->can('manage subcategories') || auth()->user()->can('edit subcategories'))
                                    <button type="button" wire:click="triggerStatusSub('{{ $sub->id }}')"
                                        class="border-0 badge {{ $sub->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2">
                                        {{ $sub->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                    @else
                                    <span class="badge {{ $sub->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2">
                                        {{ $sub->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group">
                                        @if(auth()->user()->can('manage subcategories') || auth()->user()->can('edit subcategories'))
                                        <button wire:click="editSub('{{ $sub->id }}')" class="btn btn-outline-warning border-0">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        @endif
                                        @if(auth()->user()->can('manage subcategories') || auth()->user()->can('delete subcategories'))
                                        <button wire:click="triggerDeleteSub('{{ $sub->id }}')" class="btn btn-outline-danger border-0">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">No Subcategories Found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @elseif($activeTab == 'brands')
        {{-- Brands Tab --}}
        @can('create brands')
        <div class="card card-outline {{ $editMode ? 'card-warning' : 'card-primary' }} mb-4 shadow-sm">
            <div class="card-header">
                <h3 class="card-title fw-bold">
                    <i class="bi {{ $editMode ? 'bi-pencil-square' : 'bi-plus-circle' }} me-2"></i>
                    {{ $editMode ? 'Edit Brand' : 'Add New Brand' }}
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    {{-- Logo --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Brand Logo</label>
                        <input type="file" wire:model="logo" class="form-control @error('logo') is-invalid @enderror">
                        @error('logo') <small class="text-danger">{{ $message }}</small> @enderror

                        <div class="mt-2">
                            @if($logo && is_object($logo))
                            <img src="{{ $logo->temporaryUrl() }}" width="60" class="img-thumbnail">

                            @elseif($old_logo)
                            <img src="{{ asset('storage/'.$old_logo) }}" width="60" class="img-thumbnail">
                            @endif
                        </div>
                    </div>

                    {{-- Brand Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Brand Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-tag text-muted"></i>
                            </span>
                            <input type="text" wire:model="brand_name"
                                class="form-control border-start-0 ps-1 @error('brand_name') is-invalid @enderror"
                                placeholder="Enter Brand Name">
                        </div>
                        @error('brand_name') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="d-flex gap-2 w-100">
                            @if($editMode)
                            <button wire:click="updateBrand" class="btn btn-warning flex-grow-1">Update</button>
                            <button wire:click="resetForm" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i>
                            </button>
                            @else
                            <button wire:click="saveBrand" class="btn btn-primary w-100">Save Brand</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        <div class="card card-outline card-info shadow-sm">
            <div class="card-header">
                <h3 class="card-title fw-bold">Brand List</h3>
            </div>

            <div class="card-body p-2 mt-2">
                <div class="table-responsive">
                    <table id="brandTable" class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Logo</th>
                                <th>Brand Name</th>
                                <th>Status</th>
                                <th class="text-end pe-3" style="width:150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($brands as $brand)
                            @can('view brands')
                            <tr>
                                <td class="ps-3">
                                    @if($brand->logo)
                                    <img src="{{ asset('storage/'.$brand->logo) }}" width="40" height="40" class="rounded border">
                                    @else
                                    <span class="text-muted">No Logo</span>
                                    @endif
                                </td>
                                <td class="fw-bold text-dark">{{ $brand->name }}</td>
                                <td>
                                    <button type="button" wire:click="triggerStatusBrand('{{ $brand->id }}')"
                                        class="border-0 badge {{ $brand->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2">
                                        {{ $brand->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group">
                                        @can('edit brands')
                                        <button wire:click="editBrand('{{ $brand->id }}')"
                                            onclick="window.scrollTo({top: 0, behavior: 'smooth'});" class="btn btn-outline-warning border-0">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        @endcan
                                        @can('delete brands')
                                        <button wire:click="triggerDeleteBrand('{{ $brand->id }}')" class="btn btn-outline-danger border-0">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endcan
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">No Brands Found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('livewire:navigated', () => {

        setTimeout(() => {

            initCategoryTable();
            initSubcategoryTable();
            initBrandTable();

        }, 200);

    });

    function initCategoryTable() {

        if (!$('#categoryTable').length) return;

        $('#categoryTable').DataTable({
            pageLength: 10,
            destroy: true,
            responsive: true,

            dom: '<"row align-items-center row-gap-2 mb-3"' +
                '<"col-12 col-md-4 text-center text-md-start"l>' +
                '<"col-12 col-md-8 d-flex flex-wrap justify-content-center justify-content-md-end align-items-center gap-2"Bf>' +
                '>' +
                'rt' +
                '<"row align-items-center row-gap-2 mt-3"' +
                '<"col-12 col-md-6 text-center text-md-start"i>' +
                '<"col-12 col-md-6 text-center text-md-end"p>' +
                '>',
            buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-success btn-sm border-0 shadow-sm'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-danger btn-sm border-0 shadow-sm'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    className: 'btn btn-info btn-sm text-white border-0 shadow-sm'
                }
            ]
        });

    }

    function initSubcategoryTable() {

        if (!$('#subcategoryTable').length) return;

        $('#subcategoryTable').DataTable({
            pageLength: 10,
            destroy: true,
            responsive: true,

            dom: 'Bfrtip',
            buttons: ['excel', 'pdf', 'print']
        });

    }

    function initBrandTable() {

        if (!$('#brandTable').length) return;

        $('#brandTable').DataTable({
            pageLength: 10,
            destroy: true,
            responsive: true,

            dom: 'Bfrtip',
            buttons: ['excel', 'pdf', 'print']
        });

    }

    window.addEventListener('refreshTable', () => {

        if ($.fn.DataTable.isDataTable('#categoryTable')) {
            $('#categoryTable').DataTable().destroy();
        }

        if ($.fn.DataTable.isDataTable('#subcategoryTable')) {
            $('#subcategoryTable').DataTable().destroy();
        }

        if ($.fn.DataTable.isDataTable('#brandTable')) {
            $('#brandTable').DataTable().destroy();
        }

        setTimeout(() => {
            initCategoryTable();
            initSubcategoryTable();
            initBrandTable();
        }, 200);

    });
</script>
@endpush