<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Movies;
use Illuminate\Support\Facades\Storage;

class MoviesController extends Controller
{

    public function index()
    {
        return response()->json(Movies::all(), 200);
    }
public function store(Request $request)
{
    // dd(auth()->user());
   try{
     if (auth()->user()->role !== 'admin') {
        return response()->json(['error' => 'Unauthorized'], 403);
    }



    $attributes = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'image_url' => 'required|string',
        'genre' => 'required|string',
        'duration' => 'required|numeric',
        'date' => 'required|date',
        'rating' => 'required|numeric',
        'video_url' => 'required|url',
    ]);
    

    //if i need to save photo in backend only
    // رفع الصورة إلى مجلد `storage/app/public/images`
    // $imagePath = $request->file('image_url')->store('images', 'public');

    // // تحويل المسار إلى رابط يمكن الوصول إليه من المتصفح
    // $attributes['image_url'] = asset('storage/' . $imagePath);

    $movie = Movies::create($attributes);

    return response()->json([
        'success' => true,
        'message' => 'Movie Created Successfully',
        'data' => $movie,
        'user' => auth()->user()
    ], 201);
    }
    catch(Exception $e){
        return response()->json([
            'error' => 'MovieCreationFailed',
            'message' => $e->getMessage()
        ], 400);
    }
   }

   public function show($id)
    {
        $movie = Movies::find($id);
        if (!$movie) {
            return response()->json(['error' => 'Movie not found'], 404);
        }
        return response()->json($movie, 200);
    }

    public function destroy($id)
    {
        $movie = Movies::find($id);
        if (!$movie) {
            return response()->json(['error' => 'Movie not found'], 404);
        }

        $movie->delete();
        return response()->json(['message' => 'Movie deleted successfully'], 200);
    }

}
