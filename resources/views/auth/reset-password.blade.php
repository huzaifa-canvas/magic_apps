@extends('layouts.auth')

@section('title', 'Reset Password')

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

            <h4 class="mb-1">Reset Password 🔑</h4>
            <p class="mb-5">Set a new password for your account.</p>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-5">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}"
                        class="form-control @error('email') is-invalid @enderror" autocomplete="username" required autofocus>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-5 form-password-toggle">
                    <label for="password" class="form-label">New Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            autocomplete="new-password" required>
                        <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
                    </div>
                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="mb-5 form-password-toggle">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            autocomplete="new-password" required>
                        <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary d-grid w-100">Set New Password</button>
            </form>
        </div>
    </div>
@endsection
