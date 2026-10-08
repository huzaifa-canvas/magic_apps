@extends('layouts.admin')

@section('title', 'Order #' . $order->id)

@section('content')
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
        $renderAddress = function ($address) {
            if (empty($address)) {
                return null;
            }
            if (is_string($address)) {
                return $address;
            }
            $lines = [];
            foreach ((array) $address as $key => $value) {
                if (is_array($value)) {
                    $value = implode(', ', $value);
                }
                if ($value === null || $value === '') {
                    continue;
                }
                $lines[] = ucwords(str_replace('_', ' ', $key)) . ': ' . $value;
            }
            return count($lines) ? $lines : null;
        };
        $billing = $renderAddress($order->billing_address);
        $shipping = $renderAddress($order->shipping_address);
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <span class="text-body-secondary fw-light">Store / Orders /</span> #{{ $order->id }}
        </h4>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="icon-base ti tabler-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            {{-- Order Items --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Items</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($order->items as $item)
                                <tr>
                                    <td class="fw-medium">{{ $item->product_name }}</td>
                                    <td>{{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td class="text-end">{{ number_format($item->total, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-body-secondary">No items.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Payments --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Payments</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Platform</th>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($order->payments as $payment)
                                <tr>
                                    <td class="fw-medium">{{ $payment->platform }}</td>
                                    <td>{{ $payment->transaction_id ?? '-' }}</td>
                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-label-{{ $paymentColors[$payment->status] ?? 'secondary' }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-body-secondary">No payments.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Addresses --}}
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Billing Address</h5>
                        </div>
                        <div class="card-body">
                            @if ($billing)
                                @if (is_array($billing))
                                    @foreach ($billing as $line)
                                        <div>{{ $line }}</div>
                                    @endforeach
                                @else
                                    {{ $billing }}
                                @endif
                            @else
                                <span class="text-body-secondary">Not provided.</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Shipping Address</h5>
                        </div>
                        <div class="card-body">
                            @if ($shipping)
                                @if (is_array($shipping))
                                    @foreach ($shipping as $line)
                                        <div>{{ $line }}</div>
                                    @endforeach
                                @else
                                    {{ $shipping }}
                                @endif
                            @else
                                <span class="text-body-secondary">Not provided.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Summary --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-6 fw-normal text-body-secondary">Subtotal</dt>
                        <dd class="col-6 text-end">{{ number_format($order->subtotal, 2) }}</dd>

                        <dt class="col-6 fw-normal text-body-secondary">Discount</dt>
                        <dd class="col-6 text-end">{{ number_format($order->discount, 2) }}</dd>

                        <dt class="col-6 fw-normal text-body-secondary">Tax</dt>
                        <dd class="col-6 text-end">{{ number_format($order->tax, 2) }}</dd>

                        <dt class="col-6 fw-normal text-body-secondary">Shipping</dt>
                        <dd class="col-6 text-end">{{ number_format($order->shipping, 2) }}</dd>

                        <dt class="col-6 fw-bold">Total</dt>
                        <dd class="col-6 text-end fw-bold">
                            {{ number_format($order->total, 2) }} {{ $order->currency }}
                        </dd>
                    </dl>
                    <hr>
                    <div class="mb-2">
                        <span class="text-body-secondary">Customer: </span>
                        @if ($customer)
                            <span class="fw-medium">{{ $customer->name }}</span>
                            <div><small class="text-body-secondary">{{ $customer->email }}</small></div>
                        @else
                            <span class="badge bg-label-secondary">Guest</span>
                        @endif
                    </div>
                    <div class="mb-2">
                        <span class="text-body-secondary">Status: </span>
                        <span class="badge bg-label-{{ $statusColors[$order->status] ?? 'secondary' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="text-body-secondary">Payment: </span>
                        <span class="badge bg-label-{{ $paymentColors[$order->payment_status] ?? 'secondary' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-body-secondary">Placed: </span>
                        {{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}
                    </div>
                </div>
            </div>

            {{-- Update Status --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Update Status</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="status" class="form-label">Order Status</label>
                            <select id="status" name="status"
                                class="form-select @error('status') is-invalid @enderror" required>
                                @foreach (['pending', 'processing', 'completed', 'cancelled'] as $s)
                                    <option value="{{ $s }}" {{ old('status', $order->status) == $s ? 'selected' : '' }}>
                                        {{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <select id="payment_status" name="payment_status"
                                class="form-select @error('payment_status') is-invalid @enderror" required>
                                @foreach (['unpaid', 'paid', 'refunded'] as $p)
                                    <option value="{{ $p }}"
                                        {{ old('payment_status', $order->payment_status) == $p ? 'selected' : '' }}>
                                        {{ ucfirst($p) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
