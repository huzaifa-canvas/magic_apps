@extends('layouts.admin')

@section('title', 'Edit Consultation Category')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Consultation Categories /</span> Edit</h4>
        <a href="{{ route('admin.consultation-categories.index') }}" class="btn btn-outline-secondary">
            <i class="icon-base ti tabler-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.consultation-categories.update', $consultationCategory->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $consultationCategory->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" rows="3"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description', $consultationCategory->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="icon" class="form-label">Update Icon (Optional)</label>
                            @if ($consultationCategory->icon)
                                <div class="mb-2 d-flex align-items-center gap-2">
                                    <img src="{{ \Illuminate\Support\Str::startsWith($consultationCategory->icon, 'http') ? $consultationCategory->icon : asset($consultationCategory->icon) }}"
                                        alt="{{ $consultationCategory->name }}" class="rounded border" width="64" height="64" style="object-fit: cover;">
                                    <small class="text-body-secondary">Current Icon</small>
                                </div>
                            @endif
                            <input type="file" id="icon" name="icon"
                                class="form-control @error('icon') is-invalid @enderror">
                            <small class="text-body-secondary">Leave blank to keep the current icon. Max 2MB.</small>
                            @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="is_active" class="form-label">Status</label>
                            <select id="is_active" name="is_active" class="form-select @error('is_active') is-invalid @enderror">
                                <option value="1" {{ old('is_active', $consultationCategory->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $consultationCategory->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.consultation-categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
