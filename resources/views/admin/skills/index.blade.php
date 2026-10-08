@extends('layouts.admin')

@section('title', 'User Skills')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Moderation /</span> User Skills</h4>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">All Skills</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover border-top">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Skill Type</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($skills as $skill)
                        @php
                            $owner = $users[$skill->user_id] ?? null;
                            $ownerName = $owner
                                ? (trim(($owner->first_name ?? '') . ' ' . ($owner->last_name ?? '')) ?: $owner->email)
                                : '—';
                        @endphp
                        <tr>
                            <td><span class="text-body-secondary">#{{ $skill->id }}</span></td>
                            <td>{{ $ownerName }}</td>
                            <td>{{ $skill->type->name ?? 'N/A' }}</td>
                            <td>{{ $skill->name ?: '—' }}</td>
                            <td>
                                <span class="badge bg-label-{{ $skill->status === 'completed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($skill->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-nowrap">{{ optional($skill->created_at)->format('M d, Y') }}</span>
                                <small class="d-block text-body-secondary">{{ optional($skill->created_at)->format('g:i A') }}</small>
                            </td>
                            <td class="text-end">
                                <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Delete this skill?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-body-secondary py-5">No skills found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($skills->hasPages())
            <div class="card-footer">{{ $skills->links() }}</div>
        @endif
    </div>
@endsection
