@extends('layouts.admin')

@section('title', 'Dashboard')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('theme/vendor/libs/apex-charts/apex-charts.css') }}" />
@endsection

@section('page-style')
    <style>
        .stat-card { transition: box-shadow .2s ease, transform .2s ease; }
        a.stat-card:hover { box-shadow: 0 .25rem 1rem rgba(34, 48, 62, .1); transform: translateY(-2px); }
    </style>
@endsection

@section('content')
    @php
        $cards = [
            ['label' => 'Total Users', 'value' => $stats['users'], 'icon' => 'tabler-users', 'color' => 'primary', 'route' => route('admin.users.index')],
            ['label' => 'Active Users', 'value' => $stats['active_users'], 'icon' => 'tabler-user-check', 'color' => 'success', 'route' => route('admin.users.index')],
            ['label' => 'Coaching Sessions', 'value' => $stats['coaching'], 'icon' => 'tabler-calendar-event', 'color' => 'info', 'route' => route('admin.coaching-sessions.index')],
            ['label' => 'Session Bookings', 'value' => $stats['bookings'], 'icon' => 'tabler-ticket', 'color' => 'warning', 'route' => route('admin.bookings.index')],
            ['label' => 'Feed Posts', 'value' => $stats['posts'], 'icon' => 'tabler-news', 'color' => 'secondary', 'route' => route('admin.feed-posts.index')],
            ['label' => 'Consultations', 'value' => $stats['consultations'], 'icon' => 'tabler-messages', 'color' => 'primary', 'route' => route('admin.consultations.index')],
            ['label' => 'Products', 'value' => $stats['products'], 'icon' => 'tabler-shopping-bag', 'color' => 'danger', 'route' => route('admin.products.index')],
            ['label' => 'Orders', 'value' => $stats['orders'], 'icon' => 'tabler-receipt', 'color' => 'success', 'route' => route('admin.orders.index')],
        ];
    @endphp

    <!-- Page heading -->
    <div class="mb-4">
        <h4 class="mb-1">Dashboard</h4>
        <p class="text-body-secondary mb-0">Overview of what's happening across Magic Pages.</p>
    </div>

    <!-- Stat cards (compact) -->
    <div class="row g-3 mb-4">
        @foreach ($cards as $card)
            @php $tag = $card['route'] ? 'a' : 'div'; @endphp
            <div class="col-6 col-md-4 col-xl-3">
                <{{ $tag }} @if ($card['route']) href="{{ $card['route'] }}" @endif
                    class="stat-card card h-100 text-reset text-decoration-none">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm me-3 flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-{{ $card['color'] }}">
                                    <i class="icon-base ti {{ $card['icon'] }}"></i>
                                </span>
                            </div>
                            <div class="overflow-hidden">
                                <h5 class="mb-0 lh-1 text-heading">{{ number_format($card['value']) }}</h5>
                                <small class="text-body-secondary text-truncate d-block">{{ $card['label'] }}</small>
                            </div>
                        </div>
                    </div>
                </{{ $tag }}>
            </div>
        @endforeach
    </div>

    <!-- ===== My Coaching ===== -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h5 class="mb-0">My Coaching</h5>
            <small class="text-body-secondary">Your own sessions and the bookings people make on them.</small>
        </div>
        <a href="{{ route('admin.bookings.index', ['scope' => 'mine']) }}" class="btn btn-sm btn-outline-primary">
            View my bookings
        </a>
    </div>

    @php
        $myTiles = [
            ['label' => 'My Sessions', 'value' => number_format($my['sessions']), 'icon' => 'tabler-calendar-user', 'color' => 'primary'],
            ['label' => 'My Bookings', 'value' => number_format($my['bookings']), 'icon' => 'tabler-ticket', 'color' => 'info'],
            ['label' => 'New This Month', 'value' => number_format($my['this_month']), 'icon' => 'tabler-calendar-plus', 'color' => 'success'],
            ['label' => 'Paid Revenue', 'value' => number_format($my['revenue'], 2), 'icon' => 'tabler-cash', 'color' => 'warning'],
        ];
    @endphp

    <div class="row g-3 mb-4">
        @foreach ($myTiles as $t)
            <div class="col-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-{{ $t['color'] }}">
                                <i class="icon-base ti {{ $t['icon'] }} icon-24px"></i>
                            </span>
                        </div>
                        <div class="overflow-hidden">
                            <h5 class="mb-0 lh-1 text-heading">{{ $t['value'] }}</h5>
                            <small class="text-body-secondary text-truncate d-block">{{ $t['label'] }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4 mb-4">
        <!-- My Bookings by status (cancellation) donut -->
        <div class="col-xl-5">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">My Bookings by Status</h5>
                    <small class="text-body-secondary">Booked vs completed vs cancelled</small>
                </div>
                <div class="card-body">
                    @php
                        $statusMeta = [
                            'booked' => ['Booked', 'info'],
                            'pending' => ['Pending', 'warning'],
                            'completed' => ['Completed', 'success'],
                            'cancelled' => ['Cancelled', 'danger'],
                        ];
                        $donutLabels = [];
                        $donutSeries = [];
                        $donutColors = [];
                        foreach ($myStatusCounts as $st => $cnt) {
                            $meta = $statusMeta[$st] ?? [ucfirst((string) $st), 'secondary'];
                            $donutLabels[] = $meta[0];
                            $donutSeries[] = (int) $cnt;
                            $donutColors[] = $meta[1];
                        }
                        $donutTotal = array_sum($donutSeries);
                    @endphp

                    @if ($donutTotal > 0)
                        <div id="bookingStatusChart"></div>
                        <div class="d-flex flex-wrap justify-content-center gap-4 mt-3">
                            @foreach ($donutLabels as $i => $lbl)
                                <div class="text-center">
                                    <span class="badge rounded-pill bg-label-{{ $donutColors[$i] }} mb-1">{{ $lbl }}</span>
                                    <h6 class="mb-0">{{ $donutSeries[$i] }}</h6>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-body-secondary py-6">
                            <i class="icon-base ti tabler-chart-donut icon-48px d-block mb-2 opacity-50"></i>
                            No bookings on your sessions yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent bookings for my sessions -->
        <div class="col-xl-7">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Bookings (my sessions)</h5>
                    <a href="{{ route('admin.bookings.index', ['scope' => 'mine']) }}" class="btn btn-sm btn-outline-primary">All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Booked By</th>
                                <th>Session</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $bStatus = ['booked' => 'info', 'completed' => 'success', 'cancelled' => 'danger'];
                            @endphp
                            @forelse ($recentMyBookings as $b)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <span class="avatar-initial rounded-circle bg-label-primary">
                                                    {{ strtoupper(substr($b->user->first_name ?? ($b->user->email ?? 'U'), 0, 1)) }}
                                                </span>
                                            </div>
                                            <span class="small">{{ $b->user ? (trim(($b->user->first_name ?? '') . ' ' . ($b->user->last_name ?? '')) ?: $b->user->email) : '—' }}</span>
                                        </div>
                                    </td>
                                    <td class="small">{{ $b->coachingSession->title ?? '—' }}</td>
                                    <td class="small text-body-secondary">{{ $b->booking_date ?: optional($b->created_at)->format('M d, Y') }}</td>
                                    <td><span class="badge bg-label-{{ $bStatus[$b->status] ?? 'secondary' }}">{{ ucfirst($b->status) }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-body-secondary py-5">No bookings on your sessions yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Registrations chart -->
        <div class="col-xl-7">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">User Registrations</h5>
                    <small class="text-body-secondary">Last 6 months</small>
                </div>
                <div class="card-body">
                    <div id="registrationsChart"></div>
                </div>
            </div>
        </div>

        <!-- Recent users -->
        <div class="col-xl-5">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Users</h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">All</a>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                @forelse ($recentUsers as $user)
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                                        {{ strtoupper(substr($user->first_name ?? $user->email, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 small">{{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: 'User' }}</h6>
                                                    <small class="text-body-secondary">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end pe-0">
                                            <small class="text-body-secondary">{{ optional($user->created_at)->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-body-secondary py-4">No users yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="{{ asset('theme/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('page-script')
    <script>
        (function () {
            const el = document.querySelector('#registrationsChart');
            if (!el || typeof ApexCharts === 'undefined') return;

            const primary = (window.config && window.config.colors && window.config.colors.primary) || '#7367F0';

            const options = {
                series: [{ name: 'Registrations', data: @json($registrations) }],
                chart: { type: 'bar', height: 300, toolbar: { show: false }, parentHeightOffset: 0 },
                plotOptions: { bar: { borderRadius: 6, columnWidth: '40%' } },
                colors: [primary],
                dataLabels: { enabled: false },
                grid: { strokeDashArray: 6, borderColor: (window.config && window.config.colors && window.config.colors.borderColor) || '#eee' },
                xaxis: { categories: @json($months), axisBorder: { show: false }, axisTicks: { show: false } },
                yaxis: { labels: { formatter: (v) => Math.round(v) } }
            };

            new ApexCharts(el, options).render();
        })();

        // My Bookings by status (donut) — the cancellation breakdown
        (function () {
            const el = document.querySelector('#bookingStatusChart');
            if (!el || typeof ApexCharts === 'undefined') return;

            const cfg = (window.config && window.config.colors) || {};
            const fallback = { info: '#03c3ec', warning: '#ffab00', success: '#71dd37', danger: '#ff3e1d', secondary: '#8592a3' };
            const colorKeys = @json($donutColors ?? []);
            const series = @json($donutSeries ?? []);
            const total = series.reduce((a, b) => a + b, 0);

            const options = {
                series: series,
                labels: @json($donutLabels ?? []),
                colors: colorKeys.map(k => cfg[k] || fallback[k] || fallback.secondary),
                chart: { type: 'donut', height: 260 },
                stroke: { width: 0 },
                dataLabels: { enabled: false },
                legend: { show: false },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '72%',
                            labels: {
                                show: true,
                                value: { fontSize: '1.5rem', fontWeight: 600, color: cfg.headingColor },
                                total: {
                                    show: true,
                                    label: 'Total',
                                    fontSize: '.9rem',
                                    color: cfg.textMuted,
                                    formatter: () => total
                                }
                            }
                        }
                    }
                }
            };

            new ApexCharts(el, options).render();
        })();
    </script>
@endsection
