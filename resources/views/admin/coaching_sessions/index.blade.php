@extends('layouts.admin')

@section('title', 'Coaching Sessions')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Management /</span> Coaching Sessions</h4>
        <a href="{{ route('admin.coaching-sessions.create') }}" class="btn btn-primary">
            <i class="icon-base ti tabler-plus me-1"></i> Add New Session
        </a>
    </div>

    <ul class="nav nav-pills flex-column flex-sm-row mb-4">
        <li class="nav-item">
            <a class="nav-link {{ $scope === 'mine' ? 'active' : '' }}" href="{{ route('admin.coaching-sessions.index', ['scope' => 'mine']) }}">
                <i class="icon-base ti tabler-user-star me-1"></i> My Sessions
                <span class="badge rounded-pill bg-{{ $scope === 'mine' ? 'white text-primary' : 'label-primary' }} ms-1">{{ $counts['mine'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $scope === 'users' ? 'active' : '' }}" href="{{ route('admin.coaching-sessions.index', ['scope' => 'users']) }}">
                <i class="icon-base ti tabler-users me-1"></i> User Sessions
                <span class="badge rounded-pill bg-{{ $scope === 'users' ? 'white text-primary' : 'label-secondary' }} ms-1">{{ $counts['users'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $scope === 'all' ? 'active' : '' }}" href="{{ route('admin.coaching-sessions.index', ['scope' => 'all']) }}">
                <i class="icon-base ti tabler-list me-1"></i> All
                <span class="badge rounded-pill bg-{{ $scope === 'all' ? 'white text-primary' : 'label-secondary' }} ms-1">{{ $counts['all'] }}</span>
            </a>
        </li>
    </ul>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Created By</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sessions as $session)
                        <tr>
                            <td class="fw-medium">{{ $session->title }}</td>
                            <td>{{ trim(($session->user->first_name ?? '') . ' ' . ($session->user->last_name ?? '')) ?: '—' }}</td>
                            <td>${{ number_format((float) $session->price, 2) }}</td>
                            <td>
                                <span class="badge bg-label-{{ $session->status == 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($session->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-nowrap">{{ optional($session->created_at)->format('M d, Y') }}</span>
                                <small class="d-block text-body-secondary">{{ optional($session->created_at)->format('g:i A') }}</small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.coaching-sessions.edit', $session) }}"
                                    class="btn btn-icon btn-text-secondary rounded-pill" title="Edit">
                                    <i class="icon-base ti tabler-edit"></i>
                                </a>
                                <form action="{{ route('admin.coaching-sessions.destroy', $session) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-text-danger rounded-pill" title="Delete">
                                        <i class="icon-base ti tabler-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <p class="text-body-secondary mb-3">No sessions found.</p>
                                <a href="{{ route('admin.coaching-sessions.create') }}" class="btn btn-sm btn-primary">
                                    Create Your First Session
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($sessions->hasPages())
            <div class="card-footer">{{ $sessions->links() }}</div>
        @endif
    </div>
@endsection
