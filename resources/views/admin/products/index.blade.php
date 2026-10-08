@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Store /</span> Products</h4>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="icon-base ti tabler-plus me-1"></i> Add New Product
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        @php
                            $firstImage = $product->images->first();
                            $img = $firstImage ? $firstImage->url : null;
                        @endphp
                        <tr>
                            <td>
                                @if ($img)
                                    <img src="{{ $img && \Illuminate\Support\Str::startsWith($img, 'http') ? $img : asset($img) }}"
                                        alt="{{ $product->name }}" class="rounded" width="40" height="40"
                                        style="object-fit: cover;">
                                @else
                                    <div class="avatar avatar-sm">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            <i class="icon-base ti tabler-package"></i>
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-medium">{{ $product->name }}</td>
                            <td>
                                @if (!is_null($product->sale_price) && $product->sale_price !== '')
                                    <span class="fw-medium">{{ number_format($product->sale_price, 2) }}</span>
                                    <del class="text-body-secondary small">{{ number_format($product->price, 2) }}</del>
                                @else
                                    <span class="fw-medium">{{ number_format($product->price, 2) }}</span>
                                @endif
                            </td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <span class="badge bg-label-{{ $product->status ? 'success' : 'danger' }}">
                                    {{ $product->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-nowrap">{{ optional($product->created_at)->format('M d, Y') }}</span>
                                <small class="d-block text-body-secondary">{{ optional($product->created_at)->format('g:i A') }}</small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="btn btn-icon btn-text-secondary rounded-pill" title="Edit">
                                    <i class="icon-base ti tabler-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
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
                            <td colspan="7" class="text-center py-5">
                                <p class="text-body-secondary mb-3">No products found.</p>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                                    Create Your First Product
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($products->hasPages())
            <div class="card-footer">{{ $products->links() }}</div>
        @endif
    </div>
@endsection
