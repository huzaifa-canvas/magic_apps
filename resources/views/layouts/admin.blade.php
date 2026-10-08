<!doctype html>
@php
    $assets = asset('theme') . '/';
@endphp
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="ltr"
    data-skin="default"
    data-bs-theme="light"
    data-assets-path="{{ $assets }}"
    data-template="vertical-menu-template"
    data-framework="laravel">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="robots" content="noindex, nofollow" />

    <title>@yield('title', 'Dashboard') | Magic Pages Admin</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/magic-pages-logo.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('images/magic-pages-logo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('theme/vendor/fonts/iconify-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('theme/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/vendor/libs/pickr/pickr-themes.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page Vendor CSS -->
    @yield('vendor-style')

    <!-- Page CSS -->
    @yield('page-style')

    {{-- Background / surface theme: paints the saved choice before first frame --}}
    @include('_partials._surface-theme')

    <!-- Helpers, Customizer & Config -->
    <script src="{{ asset('theme/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('theme/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ asset('theme/js/config.js') }}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('layouts.partials.admin-menu')

            <!-- Layout page -->
            <div class="layout-page">

                @include('layouts.partials.admin-navbar')

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @include('layouts.partials.admin-flash')
                        @yield('content')
                    </div>
                    <!-- / Content -->

                    @include('layouts.partials.admin-footer')

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- / Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="{{ asset('theme/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('theme/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('theme/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('theme/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('theme/vendor/libs/pickr/pickr.js') }}"></script>
    <script src="{{ asset('theme/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('theme/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('theme/vendor/js/menu.js') }}"></script>

    <!-- Page Vendor JS -->
    @yield('vendor-script')

    <!-- Main JS -->
    <script src="{{ asset('theme/js/main.js') }}"></script>

    <!-- Page JS -->
    @yield('page-script')

    {{-- Injects the "Background" swatches into the customizer + reset-in-place --}}
    @include('_partials._surface-theme-control')
</body>

</html>
