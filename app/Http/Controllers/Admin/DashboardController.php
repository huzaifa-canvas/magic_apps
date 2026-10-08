<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\FeedPost;
use App\Models\CoachingSession;
use App\Models\Badge;
use App\Models\AcademicSubject;
use App\Models\SessionBooking;
use App\Models\Consultations;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Admin dashboard overview.
     */
    public function index()
    {
        $stats = [
            'users'            => $this->safeCount(User::class),
            'active_users'     => $this->safeCount(User::class, fn ($q) => $q->where('is_active', true)),
            'coaching'         => $this->safeCount(CoachingSession::class),
            'bookings'         => $this->safeCount(SessionBooking::class),
            'posts'            => $this->safeCount(FeedPost::class),
            'consultations'    => $this->safeCount(Consultations::class),
            'products'         => $this->safeCount(Product::class),
            'orders'           => $this->safeCount(Order::class),
            'badges'           => $this->safeCount(Badge::class),
            'subjects'         => $this->safeCount(AcademicSubject::class),
        ];

        // Recent users (latest 8)
        $recentUsers = collect();
        try {
            $recentUsers = User::latest()->take(8)->get();
        } catch (\Throwable $e) {
            // leave empty on any schema mismatch
        }

        // User registrations for the last 6 months (chart data)
        $months = [];
        $registrations = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M');
            try {
                $registrations[] = User::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
            } catch (\Throwable $e) {
                $registrations[] = 0;
            }
        }

        // ---- The admin's OWN coaching: sessions + their bookings ----
        $adminId = auth()->id();
        $myBookings = fn () => SessionBooking::whereHas('coachingSession', fn ($q) => $q->where('user_id', $adminId));

        $my = [
            'sessions'   => $this->safe(fn () => CoachingSession::where('user_id', $adminId)->count()),
            'bookings'   => $this->safe(fn () => $myBookings()->count()),
            'booked'     => $this->safe(fn () => $myBookings()->where('status', 'booked')->count()),
            'completed'  => $this->safe(fn () => $myBookings()->where('status', 'completed')->count()),
            'cancelled'  => $this->safe(fn () => $myBookings()->where('status', 'cancelled')->count()),
            'this_month' => $this->safe(fn () => $myBookings()
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)->count()),
            'revenue'    => $this->safe(fn () => (float) $myBookings()->where('payment_status', 'paid')->sum('total_price')),
        ];

        // Booking status breakdown for my sessions (all statuses, accurate donut)
        $myStatusCounts = $this->safe(fn () => $myBookings()
            ->selectRaw('status, COUNT(*) as c')
            ->groupBy('status')
            ->pluck('c', 'status')
            ->toArray());
        if (! is_array($myStatusCounts)) {
            $myStatusCounts = [];
        }

        // Latest bookings for the admin's sessions
        $recentMyBookings = collect();
        try {
            $recentMyBookings = $myBookings()->with(['user', 'coachingSession'])->latest()->take(6)->get();
        } catch (\Throwable $e) {
        }

        return view('admin.dashboard', compact(
            'stats', 'recentUsers', 'months', 'registrations', 'my', 'myStatusCounts', 'recentMyBookings'
        ));
    }

    /** Run a closure, returning 0 on any error (safe dashboard aggregates). */
    private function safe(callable $fn)
    {
        try {
            return $fn();
        } catch (\Throwable $e) {
            return 0;
        }
    }

    /**
     * Count rows for a model without throwing if the table is missing.
     */
    private function safeCount(string $modelClass, ?callable $scope = null): int
    {
        try {
            $query = $modelClass::query();
            if ($scope) {
                $scope($query);
            }
            return $query->count();
        } catch (\Throwable $e) {
            return 0;
        }
    }
}
