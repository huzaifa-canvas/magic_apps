@extends('layouts.admin')

@section('title', 'Booking')

@section('content')
    @php
        $owner = $booking->user;
        $ownerName = $owner
            ? (trim(($owner->first_name ?? '') . ' ' . ($owner->last_name ?? '')) ?: $owner->email)
            : '—';
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
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Moderation / Bookings /</span> #{{ $booking->id }}</h4>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
            <i class="icon-base ti tabler-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header border-bottom"><h5 class="card-title mb-0">Booking Details</h5></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-body-secondary fw-normal">User</dt>
                        <dd class="col-sm-8">{{ $ownerName }}</dd>

                        <dt class="col-sm-4 text-body-secondary fw-normal">Session</dt>
                        <dd class="col-sm-8">{{ $booking->coachingSession->title ?? 'N/A' }}</dd>

                        <dt class="col-sm-4 text-body-secondary fw-normal">Booking date</dt>
                        <dd class="col-sm-8">{{ $booking->booking_date ?: '—' }}</dd>

                        <dt class="col-sm-4 text-body-secondary fw-normal">Time</dt>
                        <dd class="col-sm-8">{{ $booking->start_time ?: '—' }} - {{ $booking->end_time ?: '—' }}</dd>

                        <dt class="col-sm-4 text-body-secondary fw-normal">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-label-{{ $statusColors[$booking->status] ?? 'secondary' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </dd>

                        <dt class="col-sm-4 text-body-secondary fw-normal">Payment status</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-label-{{ $paymentColors[$booking->payment_status] ?? 'secondary' }}">
                                {{ ucfirst($booking->payment_status) }}
                            </span>
                        </dd>

                        <dt class="col-sm-4 text-body-secondary fw-normal">Total price</dt>
                        <dd class="col-sm-8">{{ $booking->total_price }}</dd>

                        <dt class="col-sm-4 text-body-secondary fw-normal">Payment method</dt>
                        <dd class="col-sm-8">{{ $booking->payment_method ?: '—' }}</dd>

                        <dt class="col-sm-4 text-body-secondary fw-normal">Transaction ID</dt>
                        <dd class="col-sm-8">{{ $booking->transaction_id ?: '—' }}</dd>

                        <dt class="col-sm-4 text-body-secondary fw-normal">Created</dt>
                        <dd class="col-sm-8">{{ optional($booking->created_at)->format('M d, Y H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card">
                <div class="card-header border-bottom"><h5 class="card-title mb-0">Update Status</h5></div>
                <div class="card-body">
                    <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                @foreach (['booked', 'completed', 'cancelled'] as $option)
                                    <option value="{{ $option }}" {{ $booking->status === $option ? 'selected' : '' }}>
                                        {{ ucfirst($option) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-select">
                                @foreach (['pending', 'paid', 'refunded'] as $option)
                                    <option value="{{ $option }}" {{ $booking->payment_status === $option ? 'selected' : '' }}>
                                        {{ ucfirst($option) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="icon-base ti tabler-device-floppy me-1"></i> Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
