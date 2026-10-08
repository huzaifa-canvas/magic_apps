<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SessionBooking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * List all session bookings (latest first).
     */
    public function index(Request $request)
    {
        $adminId = auth()->id();
        $scope = $request->get('scope', 'mine'); // mine = bookings for MY sessions | all

        $query = SessionBooking::with(['user', 'coachingSession'])->latest();
        if ($scope === 'mine') {
            $query->whereHas('coachingSession', fn ($q) => $q->where('user_id', $adminId));
        }

        $counts = [
            'mine' => SessionBooking::whereHas('coachingSession', fn ($q) => $q->where('user_id', $adminId))->count(),
            'all'  => SessionBooking::count(),
        ];

        $bookings = $query->paginate(20)->withQueryString();

        return view('admin.bookings.index', compact('bookings', 'scope', 'counts'));
    }

    /**
     * Show a single booking with a status update form.
     */
    public function show(SessionBooking $booking)
    {
        $booking->load(['user', 'coachingSession']);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update only the status and payment_status of a booking.
     */
    public function updateStatus(Request $request, SessionBooking $booking)
    {
        $data = $request->validate([
            'status'         => 'required|string|in:booked,completed,cancelled',
            'payment_status' => 'required|string|in:pending,paid,refunded',
        ]);

        $booking->status = $data['status'];
        $booking->payment_status = $data['payment_status'];
        $booking->save();

        return redirect()->back()->with('success', "Booking #{$booking->id} updated.");
    }
}
