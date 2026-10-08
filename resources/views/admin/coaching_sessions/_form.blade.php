@php
    $isEdit = isset($coachingSession);
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $selectedDays = old('available_days', $coachingSession->available_days ?? []);
@endphp

<form
    action="{{ $isEdit ? route('admin.coaching-sessions.update', $coachingSession) : route('admin.coaching-sessions.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="row g-4">
        <div class="col-md-6">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title"
                class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title', $coachingSession->title ?? '') }}" required autofocus>
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="price" class="form-label">Price ($)</label>
            <input type="number" step="0.01" id="price" name="price"
                class="form-control @error('price') is-invalid @enderror"
                value="{{ old('price', $coachingSession->price ?? '') }}" required>
            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12">
            <label for="short_description" class="form-label">Short Description</label>
            <textarea id="short_description" name="short_description" rows="2"
                class="form-control @error('short_description') is-invalid @enderror" required>{{ old('short_description', $coachingSession->short_description ?? '') }}</textarea>
            @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12">
            <label for="long_description" class="form-label">Long Description</label>
            <textarea id="long_description" name="long_description" rows="4"
                class="form-control @error('long_description') is-invalid @enderror" required>{{ old('long_description', $coachingSession->long_description ?? '') }}</textarea>
            @error('long_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-4">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="time" id="start_time" name="start_time"
                class="form-control @error('start_time') is-invalid @enderror"
                value="{{ old('start_time', $coachingSession->start_time ?? '') }}" required>
            @error('start_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-4">
            <label for="end_time" class="form-label">End Time</label>
            <input type="time" id="end_time" name="end_time"
                class="form-control @error('end_time') is-invalid @enderror"
                value="{{ old('end_time', $coachingSession->end_time ?? '') }}" required>
            @error('end_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-4">
            <label for="duration" class="form-label">Duration (Minutes)</label>
            <input type="number" id="duration" name="duration"
                class="form-control @error('duration') is-invalid @enderror"
                value="{{ old('duration', $coachingSession->duration ?? '') }}" required>
            @error('duration')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="meeting_link" class="form-label">Meeting Link</label>
            <input type="url" id="meeting_link" name="meeting_link"
                class="form-control @error('meeting_link') is-invalid @enderror"
                value="{{ old('meeting_link', $coachingSession->meeting_link ?? '') }}" required>
            @error('meeting_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                <option value="active" {{ old('status', $coachingSession->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $coachingSession->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12">
            <label class="form-label d-block">Available Days</label>
            <div class="d-flex flex-wrap gap-3">
                @foreach ($days as $day)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="available_days[]"
                            value="{{ $day }}" id="day_{{ $day }}"
                            {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                        <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                    </div>
                @endforeach
            </div>
            @error('available_days')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="image" class="form-label">Image</label>
            <input type="file" id="image" name="image"
                class="form-control @error('image') is-invalid @enderror" {{ $isEdit ? '' : 'required' }}>
            @if ($isEdit && !empty($coachingSession->image))
                <img src="{{ asset($coachingSession->image) }}" class="mt-2 rounded" height="80">
            @endif
            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="video" class="form-label">Video (Optional)</label>
            <input type="file" id="video" name="video"
                class="form-control @error('video') is-invalid @enderror">
            @if ($isEdit && !empty($coachingSession->video))
                <small class="text-primary d-block mt-1">Video uploaded</small>
            @endif
            @error('video')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.coaching-sessions.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">
            {{ $isEdit ? 'Update Session' : 'Create Session' }}
        </button>
    </div>
</form>
