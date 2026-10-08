@extends('layouts.admin')

@section('title', 'Edit Product Category')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Store / Product Categories /</span> Edit</h4>
        <a href="{{ route('admin.product-categories.index') }}" class="btn btn-outline-secondary">
            <i class="icon-base ti tabler-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.product-categories.update', $category->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" rows="3"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status"
                                class="form-select @error('status') is-invalid @enderror" required>
                                <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Update Category Image (Optional)</label>
                            @php $img = $category->image; @endphp
                            @if ($img)
                                <div class="mb-2 d-flex align-items-center gap-2">
                                    <img src="{{ $img && \Illuminate\Support\Str::startsWith($img, 'http') ? $img : asset($img) }}"
                                        alt="{{ $category->name }}" class="rounded border" width="64" height="64"
                                        style="object-fit: cover;">
                                    <small class="text-body-secondary">Current Image</small>
                                </div>
                            @endif
                            <input type="file" id="image" name="image"
                                class="form-control @error('image') is-invalid @enderror">
                            <small class="text-body-secondary">Leave blank to keep the current image. Max 2MB.</small>
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.product-categories.index') }}"
                                class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
