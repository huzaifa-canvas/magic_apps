@extends('layouts.admin')

@section('title', 'Skill Types')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Skill Types</h4>
        <a href="{{ route('admin.skill-types.create') }}" class="btn btn-primary">
            <i class="icon-base ti tabler-plus me-1"></i> Add New Skill Type
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($skillTypes as $row)
                        <tr>
                            <td>
                                @if ($row->icon)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($row->icon, 'http') ? $row->icon : asset($row->icon) }}"
                                        alt="{{ $row->name }}" class="rounded" width="40" height="40" style="object-fit: cover;">
                                @else
                                    <div class="avatar avatar-sm">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            <i class="icon-base ti tabler-stack-2"></i>
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-medium">{{ $row->name }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($row->description, 60) ?: '-' }}</td>
                            <td>
                                <span class="badge bg-label-{{ $row->status ? 'success' : 'danger' }}">
                                    {{ $row->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-nowrap">{{ optional($row->created_at)->format('M d, Y') }}</span>
                                <small class="d-block text-body-secondary">{{ optional($row->created_at)->format('g:i A') }}</small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.skill-types.edit', $row->id) }}"
                                    class="btn btn-icon btn-text-secondary rounded-pill" title="Edit">
                                    <i class="icon-base ti tabler-edit"></i>
                                </a>
                                <form action="{{ route('admin.skill-types.destroy', $row->id) }}" method="POST"
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
                                <p class="text-body-secondary mb-3">No skill types found.</p>
                                <a href="{{ route('admin.skill-types.create') }}" class="btn btn-sm btn-primary">
                                    Create Your First Skill Type
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($skillTypes->hasPages())
            <div class="card-footer">{{ $skillTypes->links() }}</div>
        @endif
    </div>
@endsection
