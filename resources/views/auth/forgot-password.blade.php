@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="app-brand justify-content-center mb-5">
                <a href="{{ route('login') }}" class="app-brand-link gap-2">
                    <img src="{{ asset('images/magic-pages-logo.png') }}" alt="Magic Pages" width="56" height="56"
                        style="border-radius: 50%;" />
                    <span class="app-brand-text demo text-heading fw-bold ms-2 fs-4">Magic Pages</span>
                </a>
            </div>

            <h4 class="mb-1">Forgot Password? 🔒</h4>
            <p class="mb-5">Enter your email and we'll send you a link to reset your password.</p>

            @if (session('status'))
                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form class="mb-4" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-5">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Enter your email" autofocus required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary d-grid w-100 mb-3">Send Reset Link</button>
            </form>

            <div class="text-center">
                <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                    <i class="icon-base ti tabler-chevron-left me-1"></i> Back to sign in
                </a>
            </div>
        </div>
    </div>
@endsection
