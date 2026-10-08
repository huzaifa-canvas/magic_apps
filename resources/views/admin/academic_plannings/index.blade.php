@extends('layouts.admin')

@section('title', 'Academic Plannings')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Academy /</span> Academic Plannings</h4>
    </div>

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.academic-plannings.index') }}" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label">Filter by User</label>
                    <select name="user_id" class="form-select">
                        <option value="">-- All Users --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->first_name }} {{ $user->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="icon-base ti tabler-filter me-1"></i> Filter
                    </button>
                    @if (request('user_id'))
                        <a href="{{ route('admin.academic-plannings.index') }}" class="btn btn-outline-secondary">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Trophy</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($plannings as $planning)
                        <tr>
                            <td><span class="text-body-secondary">#{{ $planning->id }}</span></td>
                            <td>{{ $planning->user->first_name ?? '' }} {{ $planning->user->last_name ?? '' }}</td>
                            <td>{{ $planning->subject->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-label-{{ $planning->status === 'completed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($planning->status) }}
                                </span>
                            </td>
                            <td>
                                @if ($planning->has_trophy)
                                    <span title="Trophy Awarded" style="font-size: 1.25rem;">🏆</span>
                                @else
                                    <span class="text-body-secondary">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-nowrap">{{ optional($planning->created_at)->format('M d, Y') }}</span>
                                <small class="d-block text-body-secondary">{{ optional($planning->created_at)->format('g:i A') }}</small>
                            </td>
                            <td class="text-end">
                                <form action="{{ route('admin.academic-plannings.toggle-trophy', $planning->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm {{ $planning->has_trophy ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                        {{ $planning->has_trophy ? 'Remove Trophy' : 'Award Trophy' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-body-secondary py-5">No Academic Plannings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($plannings->hasPages())
            <div class="card-footer">{{ $plannings->appends(request()->query())->links() }}</div>
        @endif
    </div>
@endsection
