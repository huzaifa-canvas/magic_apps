@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Management /</span> Users</h4>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label">Search</label>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                        placeholder="Name or email">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="">All roles</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-primary"><i class="icon-base ti tabler-search me-1"></i>Filter</button>
                    @if (request('q') || request('role'))
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">All Users <span class="badge bg-label-primary ms-2">{{ $users->total() }}</span></h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover border-top">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-center">Sessions</th>
                        <th>Joined</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td><span class="text-body-secondary">#{{ $user->id }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                            {{ strtoupper(substr($user->first_name ?? $user->email, 0, 1)) }}
                                        </span>
                                    </div>
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="fw-medium text-heading">
                                        {{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: '—' }}
                                    </a>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-label-{{ ($user->user_role ?? '') === 'admin' ? 'primary' : 'info' }}">
                                    {{ ucfirst($user->user_role ?? 'user') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-label-{{ $user->is_active ? 'success' : 'danger' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-flex justify-content-center mb-0">
                                    <input class="form-check-input session-toggle" type="checkbox"
                                        data-user-id="{{ $user->id }}" {{ $user->can_manage_sessions ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>{{ optional($user->created_at)->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="icon-base ti tabler-dots-vertical"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('admin.users.show', $user->id) }}">
                                            <i class="icon-base ti tabler-eye me-2"></i>View
                                        </a>
                                        @if ($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.toggle-role', $user->id) }}">
                                                @csrf
                                                <button class="dropdown-item">
                                                    <i class="icon-base ti tabler-shield me-2"></i>
                                                    {{ ($user->user_role ?? '') === 'admin' ? 'Remove admin' : 'Make admin' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.users.toggle-active', $user->id) }}">
                                                @csrf
                                                <button class="dropdown-item {{ $user->is_active ? 'text-danger' : 'text-success' }}">
                                                    <i class="icon-base ti {{ $user->is_active ? 'tabler-ban' : 'tabler-circle-check' }} me-2"></i>
                                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-body-secondary py-5">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($users->hasPages())
            <div class="card-footer">{{ $users->links() }}</div>
        @endif
    </div>
@endsection

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.session-toggle').forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    const userId = this.dataset.userId;
                    const toggle = this;
                    fetch(`/admin/users/${userId}/toggle-session-permission`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    })
                    .then(r => r.json())
                    .then(data => { if (!data.status) { toggle.checked = !toggle.checked; alert('Failed to update permission.'); } })
                    .catch(() => { toggle.checked = !toggle.checked; alert('Failed to update permission.'); });
                });
            });
        });
    </script>
@endsection
