<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Notifications;

class NotificationsController extends Controller
{
        public function index(){
            return response()->json([
                'notification'=>Notifications::all(),
            ],200);
        }  

        public function create(){
            Notifications::create([
                'user_id' =>auth()->user->id,
                'message' => request('message'),
            ]);

            return response()->json(['Success'=>'success'],200);
        }
}
