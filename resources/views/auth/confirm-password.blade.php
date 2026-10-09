@extends('layouts.auth')

@section('title', 'Confirm Password')

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

            <h4 class="mb-1">Confirm Password 🔐</h4>
            <p class="mb-5">This is a secure area. Please confirm your password before continuing.</p>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div class="mb-5 form-password-toggle">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            autocomplete="current-password" required autofocus>
                        <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
                    </div>
                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary d-grid w-100">Confirm</button>
            </form>
        </div>
    </div>
@endsection
