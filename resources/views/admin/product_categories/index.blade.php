@extends('layouts.admin')

@section('title', 'Product Categories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Store /</span> Product Categories</h4>
        <a href="{{ route('admin.product-categories.create') }}" class="btn btn-primary">
            <i class="icon-base ti tabler-plus me-1"></i> Add New Category
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        @php $img = $category->image; @endphp
                        <tr>
                            <td>
                                @if ($img)
                                    <img src="{{ $img && \Illuminate\Support\Str::startsWith($img, 'http') ? $img : asset($img) }}"
                                        alt="{{ $category->name }}" class="rounded" width="40" height="40"
                                        style="object-fit: cover;">
                                @else
                                    <div class="avatar avatar-sm">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            <i class="icon-base ti tabler-category"></i>
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-medium">{{ $category->name }}</td>
                            <td>
                                <span class="badge bg-label-{{ $category->status ? 'success' : 'danger' }}">
                                    {{ $category->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-nowrap">{{ optional($category->created_at)->format('M d, Y') }}</span>
                                <small class="d-block text-body-secondary">{{ optional($category->created_at)->format('g:i A') }}</small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.product-categories.edit', $category->id) }}"
                                    class="btn btn-icon btn-text-secondary rounded-pill" title="Edit">
                                    <i class="icon-base ti tabler-edit"></i>
                                </a>
                                <form action="{{ route('admin.product-categories.destroy', $category->id) }}" method="POST"
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
                                <p class="text-body-secondary mb-3">No product categories found.</p>
                                <a href="{{ route('admin.product-categories.create') }}" class="btn btn-sm btn-primary">
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
