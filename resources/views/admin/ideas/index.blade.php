@extends('layouts.admin')

@section('title', 'Ideas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Moderation /</span> Ideas</h4>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">All Ideas</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover border-top">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Title</th>
                        <th>Published</th>
                        <th>Featured</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ideas as $idea)
                        @php
                            $owner = $idea->user;
                            $ownerName = $owner
                                ? (trim(($owner->first_name ?? '') . ' ' . ($owner->last_name ?? '')) ?: $owner->email)
                                : '—';
                        @endphp
                        <tr>
                            <td><span class="text-body-secondary">#{{ $idea->id }}</span></td>
                            <td>{{ $ownerName }}</td>
                            <td>{{ $idea->title ?: '—' }}</td>
                            <td>
                                <span class="badge bg-label-{{ $idea->is_published ? 'success' : 'secondary' }}">
                                    {{ $idea->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td>
                                @if ($idea->is_featured)
                                    <span class="badge bg-label-warning">⭐ Featured</span>
                                @else
                                    <span class="text-body-secondary">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-nowrap">{{ optional($idea->created_at)->format('M d, Y') }}</span>
                                <small class="d-block text-body-secondary">{{ optional($idea->created_at)->format('g:i A') }}</small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.ideas.show', $idea->id) }}"
                                    class="btn btn-sm btn-outline-secondary">View</a>
                                <form action="{{ route('admin.ideas.toggle-publish', $idea->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm {{ $idea->is_published ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                        {{ $idea->is_published ? 'Unpublish' : 'Publish' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.ideas.toggle-featured', $idea->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm {{ $idea->is_featured ? 'btn-outline-secondary' : 'btn-outline-primary' }}">
                                        {{ $idea->is_featured ? 'Unfeature' : 'Feature' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.ideas.destroy', $idea->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Delete this idea?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-body-secondary py-5">No ideas found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($ideas->hasPages())
            <div class="card-footer">{{ $ideas->links() }}</div>
        @endif
    </div>
@endsection
