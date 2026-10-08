@extends('layouts.auth')

@section('title', 'Sign in')

@section('content')
    <div class="card">
        <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center mb-5">
                <a href="{{ route('login') }}" class="app-brand-link gap-2">
                    <img src="{{ asset('images/magic-pages-logo.png') }}" alt="Magic Pages" width="56" height="56"
                        style="border-radius: 50%;" />
                    <span class="app-brand-text demo text-heading fw-bold ms-2 fs-4">Magic Pages</span>
                </a>
            </div>
            <!-- /Logo -->

            <h4 class="mb-1">Welcome to Magic Pages! 👋</h4>
            <p class="mb-5">Please sign in to your admin account to continue.</p>

            {{-- Status (e.g. password reset link sent) --}}
            @if (session('status'))
                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mb-4" action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}" placeholder="Enter your email" autofocus required>
                </div>

                <div class="mb-5 form-password-toggle">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password" required>
                        <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
                    </div>
                </div>

                <div class="mb-5">
                    <div class="d-flex justify-content-between">
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" id="remember-me" name="remember">
                            <label class="form-check-label" for="remember-me">Remember Me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small">Forgot Password?</a>
                        @endif
                    </div>
                </div>

                <div class="mb-5">
                    <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                </div>
            </form>
        </div>
    </div>
@endsection
