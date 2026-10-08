@extends('layouts.admin')

@section('title', 'User Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Management / Users /</span> Detail</h4>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="icon-base ti tabler-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-primary" style="font-size:1.5rem;">
                            {{ strtoupper(substr($user->first_name ?? $user->email, 0, 1)) }}
                        </span>
                    </div>
                    <h5 class="mb-0">{{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: '—' }}</h5>
                    <p class="text-body-secondary mb-2">{{ $user->email }}</p>
                    <span class="badge bg-label-{{ ($user->user_role ?? '') === 'admin' ? 'primary' : 'info' }}">{{ ucfirst($user->user_role ?? 'user') }}</span>
                    <span class="badge bg-label-{{ $user->is_active ? 'success' : 'danger' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>

                    @if ($user->id !== auth()->id())
                        <div class="d-flex gap-2 justify-content-center mt-4">
                            <form method="POST" action="{{ route('admin.users.toggle-role', $user->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-primary">
                                    {{ ($user->user_role ?? '') === 'admin' ? 'Remove admin' : 'Make admin' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.toggle-active', $user->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-{{ $user->is_active ? 'danger' : 'success' }}">
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Details</h5></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-body-secondary fw-normal">Phone</dt>
                        <dd class="col-sm-8">{{ $user->phone ?: '—' }}</dd>

                        <dt class="col-sm-4 text-body-secondary fw-normal">Can manage sessions</dt>
                        <dd class="col-sm-8">{{ $user->can_manage_sessions ? 'Yes' : 'No' }}</dd>

                        <dt class="col-sm-4 text-body-secondary fw-normal">Email verified</dt>
                        <dd class="col-sm-8">{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y') : 'Not verified' }}</dd>

                        <dt class="col-sm-4 text-body-secondary fw-normal">Joined</dt>
                        <dd class="col-sm-8">{{ optional($user->created_at)->format('M d, Y') }}</dd>

                        @if ($user->profile)
                            <dt class="col-sm-4 text-body-secondary fw-normal">Gender</dt>
                            <dd class="col-sm-8">{{ $user->profile->gender ?: '—' }}</dd>

                            <dt class="col-sm-4 text-body-secondary fw-normal">Date of birth</dt>
                            <dd class="col-sm-8">{{ $user->profile->born_date ?: '—' }}</dd>

                            <dt class="col-sm-4 text-body-secondary fw-normal">Bio</dt>
                            <dd class="col-sm-8">{{ $user->profile->bio ?: '—' }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
