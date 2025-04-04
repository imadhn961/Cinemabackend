<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedules;
use App\Models\Seats;
use App\Models\Bookings;


class SchedulesController extends Controller
{
 public function index()
 {
     return response()->json([
         'schedules' => Schedules::all(),
     ],200);
 }
 public function create(){
    request()->validate([
        'movie_id' => 'required|exists:movies,id',
        'hall_id' => 'required|exists:halls,id',
        'start' => 'required|date',
        'end' => 'required|date|after:start_time',
        'price'=> 'required|numeric|min:0',
    ]);
    $schedule = Schedules::create([
        'movie_id' => request('movie_id'),
        'hall_id' => request('hall_id'),
        'start' => request('start'),
        'end' => request('end'),

        'price' => request('price'),
    ]);

    return response()->json([
        'message' => 'Schedule created successfully',
        'schedule' => $schedule,
    ],200);

 }
    public function show($id)
    {
        $schedule = Schedules::findOrFail($id);
        return response()->json([
            'schedule' => $schedule,
        ]);
    }
    public function update($id)
    {
        $schedule = Schedules::findOrFail($id);
        request()->validate([
            'movie_id' => 'required|exists:movies,id',
            'hall_id' => 'required|exists:halls,id',
            'start' => 'required|date',
            'end' => 'required|date|after:start_time',
            'price'=> 'required|numeric|min:0',
        ]);
        $schedule->update([
            'movie_id' => request('movie_id'),
            'hall_id' => request('hall_id'),
            'start' => request('start'),
              'end ' => request('end'),
            'price' => request('price'),
        ]);

        return response()->json([
            'message' => 'Schedule updated successfully',
            'schedule' => $schedule,
        ],200);
    }
    public function destroy($id)
    {
        $schedule = Schedules::findOrFail($id);
        $schedule->delete();
        return response()->json([
            'message' => 'Schedule deleted successfully',
        ],200);
    }
}
