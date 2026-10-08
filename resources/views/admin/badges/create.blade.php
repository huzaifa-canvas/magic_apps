@extends('layouts.admin')

@section('title', 'Create Badge')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Academy / Badges /</span> Create</h4>
        <a href="{{ route('admin.badges.index') }}" class="btn btn-outline-secondary">
            <i class="icon-base ti tabler-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.badges.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label">Badge Name</label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="e.g. Gold Skills" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" rows="3"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Brief description">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="type" class="form-label">Progress Type</label>
                                <select id="type" name="type"
                                    class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="skills" {{ old('type') == 'skills' ? 'selected' : '' }}>Skills</option>
                                    <option value="goals" {{ old('type') == 'goals' ? 'selected' : '' }}>Goals</option>
                                </select>
                                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="required_amount" class="form-label">Required Amount</label>
                                <input type="number" id="required_amount" name="required_amount" min="1"
                                    class="form-control @error('required_amount') is-invalid @enderror"
                                    placeholder="e.g. 50" value="{{ old('required_amount') }}" required>
                                @error('required_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="icon" class="form-label">Badge Icon (Image, max 2MB)</label>
                            <input type="file" id="icon" name="icon"
                                class="form-control @error('icon') is-invalid @enderror" required>
                            @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.badges.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Badge</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
