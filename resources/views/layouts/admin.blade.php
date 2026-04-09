<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    @if($settings && $settings->favicon)
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $settings->favicon) }}">
    @else
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance." />
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant" />
    <meta name="supported-color-schemes" content="light dark" />
    @include('admin.partials.header_links')

    @livewireStyles
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <div class="app-wrapper">
        @include('admin.partials.header')
        @include('admin.partials.sidebar')
        <main class="app-main">
            <div class="p-2">
                {{ $slot }}
            </div>
        </main>
        @include('admin.partials.footer')
    </div>
    @include('admin.partials.footer_links')
    @livewireScripts
    <style>
        @media (max-width: 576px) {
            .dt-buttons {
                width: 100%;
                display: flex;
                justify-content: center;
                margin-bottom: 10px;
            }

            .dt-buttons btn {
                flex-grow: 1;
            }

            .dataTables_filter {
                width: 100%;
            }

            .dataTables_filter input {
                width: 100% !important;
                margin-left: 0 !important;
            }

            .dataTables_info,
            .dataTables_paginate {
                text-align: center !important;
                width: 100%;
                margin-top: 10px;
            }
        }

        .dt-buttons .btn {
            margin: 2px;
            border-radius: 6px !important;
        }
    </style>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('livewire:navigated', () => {

            setTimeout(() => {

                if ($('#dataTable').length) {
                    initDataTable();
                }

            }, 200);

        });

        function initDataTable() {
            $('#dataTable').DataTable({
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
                ],

                language: {
                    search: "",
                    searchPlaceholder: "Search...",
                    lengthMenu: "_MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_",
                    paginate: {
                        next: "»",
                        previous: "«"
                    }
                }
            });

            $('.dataTables_filter input').addClass('form-control form-control-sm d-inline-block').css('width', 'auto');
            $('.dataTables_length select').addClass('form-select form-select-sm d-inline-block').css('width', 'auto');

        }


        window.addEventListener('refreshTable', () => {

            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().destroy();
            }

            setTimeout(() => {
                initDataTable();
            }, 100);

        });


        window.addEventListener('swal', event => {
            let data = Array.isArray(event.detail) ? event.detail[0] : event.detail;
            Swal.fire({
                title: data.title || 'Success',
                icon: data.icon || 'success',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });

        window.addEventListener('swal:confirm', event => {


            let data = Array.isArray(event.detail) ? event.detail[0] : event.detail;

            Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.type,
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Proceed!',
                customClass: {
                    confirmButton: 'btn btn-danger px-4 mx-2',
                    cancelButton: 'btn btn-secondary px-4 mx-2'
                },
            }).then((result) => {

                if (result.isConfirmed) {
                    window.Livewire.dispatch(data.nextAction, {
                        id: data.id
                    });
                }

            });

        });
    </script>

</body>

</html>