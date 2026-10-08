@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Store /</span> Orders</h4>
    </div>

    @php
        $statusColors = [
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
        ];
        $paymentColors = [
            'unpaid' => 'warning',
            'paid' => 'success',
            'refunded' => 'secondary',
        ];
    @endphp

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        @php $user = $order->user_id ? ($users[$order->user_id] ?? null) : null; @endphp
                        <tr>
                            <td class="fw-medium">#{{ $order->id }}</td>
                            <td>
                                @if ($user)
                                    <span class="fw-medium d-block">{{ $user->name }}</span>
                                    <small class="text-body-secondary">{{ $user->email }}</small>
                                @else
                                    <span class="badge bg-label-secondary">Guest</span>
                                @endif
                            </td>
                            <td>{{ number_format($order->total, 2) }} {{ $order->currency }}</td>
                            <td>
                                <span class="badge bg-label-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-label-{{ $paymentColors[$order->payment_status] ?? 'secondary' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-nowrap">{{ optional($order->created_at)->format('M d, Y') }}</span>
                                <small class="d-block text-body-secondary">{{ optional($order->created_at)->format('g:i A') }}</small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                    class="btn btn-icon btn-text-secondary rounded-pill" title="View">
                                    <i class="icon-base ti tabler-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <p class="text-body-secondary mb-0">No orders found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($orders->hasPages())
            <div class="card-footer">{{ $orders->links() }}</div>
        @endif
    </div>
@endsection
