<aside class="shadow app-sidebar bg-body-secondary" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a wire:navigate.hover class="brand-link">
            <!--begin::Brand Image-->
            {{-- <img src="{{ asset('storage/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="shadow opacity-75 brand-image" /> --}}
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            @role('Admin')
            @php
            $store = \App\Models\Store::where('admin_id', auth()->id())->first();
            @endphp

            <span class="brand-text fw-light">
                {{ $store ? $store->name : 'Admin' }}
            </span>
            @endrole


            @role('Super Admin')
            <span class="brand-text fw-light">
                {{ $settings->website_name ?? 'Super Admin' }}
            </span>
            @endrole
            @role('Store Manager')
            <span class="brand-text fw-light">Store Manager</span>
            @endrole
            @role('Employee POS')
            <span class="brand-text fw-light">Employee POS</span>
            @endrole
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">
                @role('Super Admin')
                <li class="nav-header text-uppercase small fw-bold text-muted mt-3">Administration</li>

                {{-- Super Dashboard --}}
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('superadmin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2 text-danger"></i>
                        <p>Super Dashboard</p>
                    </a>
                </li>

                {{-- Role & Permission --}}
                @can('view users')
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('superadmin.users.index') }}"
                        class="nav-link {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-shield-check text-primary"></i>
                        <p>Role & Permission</p>
                    </a>
                </li>
                @endcan

                {{-- Store Management --}}
                @can('view stores')
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('superadmin.stores.index') }}"
                        class="nav-link {{ request()->routeIs('superadmin.stores.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-shop-window text-success"></i>
                        <p>Store Management</p>
                    </a>
                </li>
                @endcan

                {{-- Loyalty Settings --}}
                @can('manage loyalty')
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('superadmin.loyalty.index') }}"
                        class="nav-link {{ request()->routeIs('superadmin.loyalty.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-gem text-warning"></i>
                        <p>Loyalty Settings</p>
                    </a>
                </li>
                @endcan

                {{-- Reports --}}
                @can('view reports')
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('superadmin.reports.index') }}"
                        class="nav-link {{ request()->routeIs('superadmin.reports.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-pie-chart-fill text-info"></i>
                        <p>Analytics Reports</p>
                    </a>
                </li>
                @endcan

                {{-- Settings --}}
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('superadmin.settings.index') }}"
                        class="nav-link {{ request()->routeIs('superadmin.settings.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-toggles2 text-light"></i>
                        <p>System Config</p>
                    </a>
                </li>
                @endrole
                {{-- Admin Role --}}
                @role('Admin')
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2 text-danger"></i>
                        <p>Admin Dashboard</p>
                    </a>
                </li>

                @can('view managers')
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('admin.manager.index') }}"
                        class="nav-link {{ request()->routeIs('admin.manager.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-shield-check text-primary"></i>
                        <p>Staff Authority</p>
                    </a>
                </li>
                @endcan

                @if(auth()->user()->can('view products') || auth()->user()->can('view categories') ||
                auth()->user()->can('manage products') || auth()->user()->can('manage categories'))

                <li class="nav-item {{ request()->routeIs('admin.catalog', 'admin.products') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.catalog', 'admin.products') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-diagram-3-fill text-success"></i>
                        <p>
                            Manage Catalog
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        {{-- Product Catalog (Categories) --}}
                        @if(auth()->user()->can('view categories') || auth()->user()->can('manage categories'))
                        <li class="nav-item">
                            <a wire:navigate.hover href="{{ route('admin.catalog') }}"
                                class="nav-link {{ request()->routeIs('admin.catalog') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Product Catalog</p>
                            </a>
                        </li>
                        @endif

                        {{-- Products List --}}
                        @if(auth()->user()->can('view products') || auth()->user()->can('manage products'))
                        <li class="nav-item">
                            <a wire:navigate.hover href="{{ route('admin.products') }}"
                                class="nav-link {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Products List</p>
                            </a>
                        </li>
                        @endif

                    </ul>
                </li>
                @endif

                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('admin.orders.index') }}"
                        class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cart-fill text-warning"></i>
                        <p>Orders</p>
                    </a>
                </li>

                @can('view reports')
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('admin.reports.index') }}"
                        class="nav-link {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-pie-chart-fill text-info"></i>
                        <p>Reports</p>
                    </a>
                </li>
                @endcan

                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('admin.coupons') }}"
                        class="nav-link {{ request()->routeIs('admin.coupons') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-tags text-primary"></i>
                        <p>Coupons</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('admin.settings') }}"
                        class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-toggles2 text-light"></i>
                        <p>Settings</p>
                    </a>
                </li>
                @endrole

                {{-- Store Manager Role --}}
                @role('Store Manager')
                @can('view stores')
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('store.dashboard') }}"
                        class="nav-link {{ request()->routeIs('store.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2 text-warning"></i>
                        <p>Manager Dashboard</p>
                    </a>
                </li>
                @endcan
                @can('view stores')
                @if(auth()->user()->can('view categories') || auth()->user()->can('manage categories') ||
                auth()->user()->can('view products') || auth()->user()->can('manage products'))

                <li class="nav-item {{ request()->routeIs('store.catalog', 'store.products') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('store.catalog', 'store.products') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-diagram-3-fill"></i>
                        <p>
                            Manage
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        {{-- Product Catalog (Categories) --}}
                        @if(auth()->user()->can('view categories') || auth()->user()->can('manage categories') ||
                        auth()->user()->can('view subcategories') || auth()->user()->can('manage subcategories'))
                        <li class="nav-item">
                            <a wire:navigate.hover href="{{ route('store.catalog') }}"
                                class="nav-link {{ request()->routeIs('store.catalog') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Product Catalog</p>
                            </a>
                        </li>
                        @endif

                        {{-- Products --}}
                        @if(auth()->user()->can('view products') || auth()->user()->can('manage products'))
                        <li class="nav-item">
                            <a href="{{ route('store.products') }}"
                                class="nav-link {{ request()->routeIs('store.products') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        @endif

                    </ul>
                </li>
                @endif
                @endcan
                @can('view stores')
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('store.manager.index') }}"
                        class="nav-link {{ request()->routeIs('store.manager.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-building-gear"></i>
                        <p>Staff Authority</p>
                    </a>
                </li>
                @endcan
                @can('view pos')
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('store.manager.pos') }}"
                        class="nav-link {{ request()->routeIs('store.manager.pos') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cart-check text-success"></i>
                        <p>New Sale (POS)</p>
                    </a>
                </li>
                @endcan

                @can('view orders')
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('store.manager.order.index') }}"
                        class="nav-link {{ request()->routeIs('store.manager.order.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cart-fill text-warning"></i>
                        <p>Orders</p>
                    </a>
                </li>
                @endcan
                @endrole

                @role('Employee POS')
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('employee.dashboard') }}"
                        class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2 text-info"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @can('view inventory')
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('employee.inventory') }}"
                        class="nav-link {{ request()->routeIs('employee.inventory') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box-seam text-warning"></i>
                        <p>Check Stock</p>
                    </a>
                </li>
                @endcan

                @if(auth()->user()->can('view categories') || auth()->user()->can('manage categories') ||
                auth()->user()->can('view products') || auth()->user()->can('manage products'))
                <li class="nav-item">
                    <a href="#manageCollapse"
                        data-bs-toggle="collapse"
                        role="button"
                        aria-expanded="{{ request()->routeIs('employee.store.catalog', 'store.products') ? 'true' : 'false' }}"
                        aria-controls="manageCollapse"
                        class="nav-link {{ request()->routeIs('employee.store.catalog', 'store.products') ? 'active' : '' }}">

                        <i class="nav-icon bi bi-grid-1x2-fill text-primary"></i>
                        <p>
                            Manage
                            <i class="nav-arrow bi bi-chevron-right float-end"></i>
                        </p>
                    </a>

                    <div class="collapse {{ request()->routeIs('employee.store.catalog', 'employee.store.products') ? 'show' : '' }}" id="manageCollapse">
                        <ul class="nav nav-treeview d-block" style="padding-left: 15px;">

                            @if(auth()->user()->can('view categories') || auth()->user()->can('manage categories'))
                            <li class="nav-item">
                                <a wire:navigate.hover href="{{ route('employee.store.catalog') }}"
                                    class="nav-link {{ request()->routeIs('employee.store.catalog') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-tags text-success"></i>
                                    <p>Product Catalog</p>
                                </a>
                            </li>
                            @endif

                            @if(auth()->user()->can('view products') || auth()->user()->can('manage products'))
                            <li class="nav-item">
                                <a wire:navigate.hover href="{{ route('employee.store.products') }}"
                                    class="nav-link {{ request()->routeIs('employee.store.products') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-cart-plus text-info"></i>
                                    <p>Products</p>
                                </a>
                            </li>
                            @endif

                        </ul>
                    </div>
                </li>
                @endcan

                @can('view orders')
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('employee.order.index') }}"
                        class="nav-link {{ request()->routeIs('employee.order.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cart-fill text-warning"></i>
                        <p>Orders</p>
                    </a>
                </li>
                @endcan

                @can('view pos')
                <li class="nav-item">
                    <a wire:navigate.hover href="{{ route('employee.pos') }}"
                        class="nav-link {{ request()->routeIs('employee.pos') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cart-check text-success"></i>
                        <p>New Sale (POS)</p>
                    </a>
                </li>
                @endcan

                @endrole
            </ul>
        </nav>
    </div>
</aside>