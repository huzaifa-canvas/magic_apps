@extends('layouts.admin')

@section('title', 'Edit Session')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Coaching Sessions /</span> Edit</h4>
        <a href="{{ route('admin.coaching-sessions.index') }}" class="btn btn-outline-secondary">
            <i class="icon-base ti tabler-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @include('admin.coaching_sessions._form')
        </div>
    </div>
@endsection
