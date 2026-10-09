@extends('layouts.auth')

@section('title', 'Verify Email')

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

            <h4 class="mb-1">Verify Your Email ✉️</h4>
            <p class="mb-5">We've emailed you a verification link. Click it to activate your account. Didn't get it? Resend below.</p>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success" role="alert">
                    A new verification link has been sent to your email address.
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                @csrf
                <button type="submit" class="btn btn-primary d-grid w-100">Resend Verification Email</button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="btn btn-link text-body-secondary p-0">Log Out</button>
            </form>
        </div>
    </div>
@endsection
