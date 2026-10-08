@extends('layouts.admin')

@section('title', 'Bookings')

@section('content')
    @php
        $statusColors = [
            'booked' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
        ];
        $paymentColors = [
            'pending' => 'warning',
            'paid' => 'success',
            'refunded' => 'secondary',
        ];
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Coaching /</span> Bookings</h4>
    </div>

    <ul class="nav nav-pills flex-column flex-sm-row mb-4">
        <li class="nav-item">
            <a class="nav-link {{ $scope === 'mine' ? 'active' : '' }}" href="{{ route('admin.bookings.index', ['scope' => 'mine']) }}">
                <i class="icon-base ti tabler-user-star me-1"></i> My Sessions' Bookings
                <span class="badge rounded-pill bg-{{ $scope === 'mine' ? 'white text-primary' : 'label-primary' }} ms-1">{{ $counts['mine'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $scope === 'all' ? 'active' : '' }}" href="{{ route('admin.bookings.index', ['scope' => 'all']) }}">
                <i class="icon-base ti tabler-list me-1"></i> All Bookings
                <span class="badge rounded-pill bg-{{ $scope === 'all' ? 'white text-primary' : 'label-secondary' }} ms-1">{{ $counts['all'] }}</span>
            </a>
        </li>
    </ul>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">{{ $scope === 'mine' ? "Bookings for my sessions" : 'All Bookings' }}</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover border-top">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Session</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Price</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        @php
                            $owner = $booking->user;
                            $ownerName = $owner
                                ? (trim(($owner->first_name ?? '') . ' ' . ($owner->last_name ?? '')) ?: $owner->email)
                                : '—';
                        @endphp
                        <tr>
                            <td><span class="text-body-secondary">#{{ $booking->id }}</span></td>
                            <td>{{ $ownerName }}</td>
                            <td>{{ $booking->coachingSession->title ?? 'N/A' }}</td>
                            <td>{{ $booking->booking_date ?: '—' }}</td>
                            <td>
                                <span class="badge bg-label-{{ $statusColors[$booking->status] ?? 'secondary' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-label-{{ $paymentColors[$booking->payment_status] ?? 'secondary' }}">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </td>
                            <td>{{ $booking->total_price }}</td>
                            <td>
                                <span class="text-nowrap">{{ optional($booking->created_at)->format('M d, Y') }}</span>
                                <small class="d-block text-body-secondary">{{ optional($booking->created_at)->format('g:i A') }}</small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                    class="btn btn-sm btn-outline-secondary">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-body-secondary py-5">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($bookings->hasPages())
            <div class="card-footer">{{ $bookings->links() }}</div>
        @endif
    </div>
@endsection
