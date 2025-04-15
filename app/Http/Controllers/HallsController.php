<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Halls;
use Exception;

class HallsController extends Controller
{
   public function store(){
   try{ request()->validate([
        'name' => 'required',
        'capacity' => 'required',
    ]);
    $hall = Halls::create([

        'name' => request('name'),
        'capacity' => request('capacity'),
    ]);
    return response()->json([
              'message' => 'Hall created successfully',
              "hall" => $hall
         ],200);
   }catch(Exception $e){
         return response()->json([
              'message' => 'Hall creation failed'

         ]);
   }}

   public function index(){
    $halls = Halls::all();
    return response()->json([
        'halls' => $halls
    ]);
   }

   public function destroy($id){
    $hall = Halls::find($id);
    if($hall){
        $hall->delete();
        return response()->json([
            'message' => 'Hall deleted successfully'
        ]);
    }else{
        return response()->json([
            'message' => 'Hall not found'
        ]);
    }
   }

   public function edit($id){
    $hall = Halls::find($id)->first();
    $hall->update([
        'name'     => request('name'),
        'capacity' => request('capacity')
    ]);
    if($hall){
        return response()->json([
             'message' => 'Hall Update Succesfully'
        ]);
    }else{
        return response()->json([
            'message' => 'Hall not found'
        ]);
    }
   }
}
