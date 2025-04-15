<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seats;

class SeatsController extends Controller
{
    public function index(){
        return response()->json([
            'seats' => Seats::all(),
        ],200);
          
        
    }


    public function create(){
        request()->validate([
            'hall_id' => 'required',
            'number' => 'required',
            'row' => 'required',
        ]);
        $seat = Seats::create([
            'hall_id' => request('hall_id'),
            'number' => request(key: 'number'),
            'row' => request('row'),
        ]);
        return response()->json([
            'message' => 'Seat created successfully',
            "Seats" => $seat
        ]);
    }

    public function destroy($id){
        $seat = Seats::find($id);
        if($seat){
            $seat->delete();
            return response()->json([
                'message' => 'Seat deleted successfully'
            ]);
        }else{
            return response()->json([
                'message' => 'Seat not found'
            ]);
        }
    }
}
