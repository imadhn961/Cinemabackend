<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\HallsController;
use App\Http\Controllers\SeatsController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PaymentsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'user' => auth()->user()
    ]);
});

Route::post('Register',[Controller::class , 'create']);
Route::post('Login' , [Controller::class , 'login']);
Route::post('auth/google', [Controller::class, 'googleAuth']);
Route::get('/movies', [MoviesController::class, 'index']); 
Route::post('/movies', [MoviesController::class, 'store'])->middleware('auth:sanctum'); 
Route::get('/movies/{id}', [MoviesController::class, 'show']); 
Route::delete('/movies/{id}', [MoviesController::class, 'destroy']);
Route::post('halls' , [ HallsController::class , 'store']);
Route::get('halls' , [ HallsController::class , 'index']);
Route::delete('halls/{id}' , [ HallsController::class , 'destroy'])->middleware('auth:sanctum');
Route::post('halls/{id}',[HallsController::class , 'edit'])->middleware('auth:sanctum');
Route::post('seats',[SeatsController::class , 'create'])->middleware('auth:sanctum');
Route::get('seats',[SeatsController::class , 'index']);
Route::delete('seats/{id}',[SeatsController::class , 'destroy']);
Route::post('schedules',[SchedulesController::class , 'create'])->middleware('auth:sanctum');
Route::get('schedules',[SchedulesController::class , 'index']);
Route::get('schedules/{id}',[SchedulesController::class , 'show']);
Route::post('schedules/{id}',[SchedulesController::class , 'update']);
Route::delete('schedules/{id}',[SchedulesController::class , 'destroy']);
Route::post('booking',[BookingsController::class , 'create']);
Route::delete('booking/{id}',[BookingsController::class , 'destroy']);
Route::get('booking' , [BookingsController::class , 'index']);
Route::get('notification',[NotificationsController::class , 'index']);
Route::post('notification',[NotificationsController::class , 'create'])->middleware('auth:sanctum');
Route::post('Payment',[PaymentsController::class , 'create'])->middleware('auth:sanctum');

