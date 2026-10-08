<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="layout-wide customizer-hide"
    dir="ltr" data-skin="default" data-bs-theme="light"
    data-assets-path="{{ asset('theme') }}/" data-template="vertical-menu-template" data-framework="laravel">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="robots" content="noindex, nofollow" />

    <title>@yield('title', 'Sign in') | Magic Pages Admin</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/magic-pages-logo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons & Core CSS -->
    <link rel="stylesheet" href="{{ asset('theme/vendor/fonts/iconify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('theme/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('theme/js/config.js') }}"></script>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-6">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('theme/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('theme/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('theme/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('theme/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('theme/js/main.js') }}"></script>

    <!-- Password show/hide toggle (document-level delegation = works regardless of load timing) -->
    <script>
        document.addEventListener('click', function (e) {
            const toggle = e.target.closest('.input-group-text');
            if (!toggle) return;
            const wrap = toggle.closest('.form-password-toggle');
            if (!wrap) return;
            const input = wrap.querySelector('input');
            if (!input) return;
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            const icon = toggle.querySelector('i');
            if (icon) {
                icon.classList.toggle('tabler-eye', show);
                icon.classList.toggle('tabler-eye-off', !show);
            }
        });
    </script>

    @yield('page-script')
</body>

</html>
