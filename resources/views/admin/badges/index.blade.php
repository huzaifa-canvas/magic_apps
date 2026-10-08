@extends('layouts.admin')

@section('title', 'Badges')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Academy /</span> Badges</h4>
        <a href="{{ route('admin.badges.create') }}" class="btn btn-primary">
            <i class="icon-base ti tabler-plus me-1"></i> Add New Badge
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Required Amount</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($badges as $badge)
                        <tr>
                            <td>
                                <img class="rounded-circle" src="{{ asset($badge->icon) }}" alt="{{ $badge->name }}"
                                    width="40" height="40" style="object-fit: cover;">
                            </td>
                            <td class="fw-medium">{{ $badge->name }}</td>
                            <td><span class="badge bg-label-info text-capitalize">{{ $badge->type }}</span></td>
                            <td>{{ $badge->required_amount }}</td>
                            <td>
                                <span class="text-nowrap">{{ optional($badge->created_at)->format('M d, Y') }}</span>
                                <small class="d-block text-body-secondary">{{ optional($badge->created_at)->format('g:i A') }}</small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.badges.edit', $badge->id) }}"
                                    class="btn btn-icon btn-text-secondary rounded-pill" title="Edit">
                                    <i class="icon-base ti tabler-edit"></i>
                                </a>
                                <form action="{{ route('admin.badges.destroy', $badge->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Are you sure you want to delete this badge?')">
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
                                <p class="text-body-secondary mb-3">No badges found.</p>
                                <a href="{{ route('admin.badges.create') }}" class="btn btn-sm btn-primary">
                                    Create Your First Badge
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
