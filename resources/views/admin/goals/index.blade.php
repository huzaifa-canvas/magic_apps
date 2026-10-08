@extends('layouts.admin')

@section('title', 'User Goals')

@section('content')
    @php
        $statusColors = [
            'not_initiated' => 'secondary',
            'in_progress' => 'info',
            'completed' => 'success',
            'in_active' => 'warning',
        ];
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Moderation /</span> User Goals</h4>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">All Goals</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover border-top">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Goal</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Completion Date</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($goals as $goal)
                        @php
                            $owner = $goal->user;
                            $ownerName = $owner
                                ? (trim(($owner->first_name ?? '') . ' ' . ($owner->last_name ?? '')) ?: $owner->email)
                                : '—';
                        @endphp
                        <tr>
                            <td><span class="text-body-secondary">#{{ $goal->id }}</span></td>
                            <td>{{ $ownerName }}</td>
                            <td>{{ $goal->goal ?: '—' }}</td>
                            <td>
                                <span class="badge bg-label-{{ $goal->type === 'long' ? 'primary' : 'info' }}">
                                    {{ ucfirst($goal->type) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-label-{{ $statusColors[$goal->status] ?? 'secondary' }}">
                                    {{ ucfirst(str_replace('_', ' ', $goal->status)) }}
                                </span>
                            </td>
                            <td>{{ $goal->completion_date ?: '—' }}</td>
                            <td>
                                <span class="text-nowrap">{{ optional($goal->created_at)->format('M d, Y') }}</span>
                                <small class="d-block text-body-secondary">{{ optional($goal->created_at)->format('g:i A') }}</small>
                            </td>
                            <td class="text-end">
                                <form action="{{ route('admin.goals.destroy', $goal->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Delete this goal?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-body-secondary py-5">No goals found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($goals->hasPages())
            <div class="card-footer">{{ $goals->links() }}</div>
        @endif
    </div>
@endsection
