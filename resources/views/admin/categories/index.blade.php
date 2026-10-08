@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Categories</h4>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="icon-base ti tabler-plus me-1"></i> Add New Category
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $row)
                        <tr>
                            <td class="fw-medium">{{ $row->name }}</td>
                            <td>{{ $row->slug }}</td>
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
                                <a href="{{ route('admin.categories.edit', $row->id) }}"
                                    class="btn btn-icon btn-text-secondary rounded-pill" title="Edit">
                                    <i class="icon-base ti tabler-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $row->id) }}" method="POST"
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
                            <td colspan="5" class="text-center py-5">
                                <p class="text-body-secondary mb-3">No categories found.</p>
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
                                    Create Your First Category
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($categories->hasPages())
            <div class="card-footer">{{ $categories->links() }}</div>
        @endif
    </div>
@endsection
