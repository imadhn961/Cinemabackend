<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookings;

class BookingsController extends Controller
{
    public function index()
    {
        return response()->json([
            'bookings' => Bookings::all(),
        ], 200);
    }

    public function create()
    {
        request()->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seat_id' => 'required|exists:seats,id',
        ]);

        $booking = Bookings::create([
            'schedule_id' => request('schedule_id'),
            'seat_id'     => request('seat_id'),
            'user_id'     => auth()->user->id,
            'status'      => request('status', 'pending'), // default status
        ]);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking,
        ], 200);
    }
    public function destroy($id){
        $booking = Bookings::find($id);
        $booking->delete();

        return response()->json([
            'message' => 'Deleted'
        ],200);
    }
}
