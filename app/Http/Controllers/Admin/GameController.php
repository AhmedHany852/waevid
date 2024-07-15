<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $games = Game::paginate($request->get('per_page', 50));
        foreach($games as $game){
            if( $game->photo){
                $game->photo = asset('uploads/games_photo/'.$game->photo)  ;
            }
        }
        return response()->json(['successful ' => true, 'data' =>    $games], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'photo' => 'required|image|mimes:jpeg,webp,png,jpg,gif,pdf|max:2048',


        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 400);
        }
        if ($request->file('photo')) {
            $avatar = $request->file('photo');
            $photo = upload($avatar,public_path('uploads/games_photo/'));
        } else {
            $photo = null;
        }
        $games = Game::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'photo' => $photo,
            'status' => $request->status,
            'photo_description' => $request->photo_description,

        ]);
        if(   $games->photo){
             $games->photo = asset('uploads/games_photo/'.  $games->photo)  ;
       }
        return response()->json(['successful' => true, 'data' =>    $games], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        if( $game->photo){
            $game->photo = asset('uploads/games_photo/'.$game->photo)  ;
        }
        return response()->json(['successful' => true, 'data' => $game], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpeg,webp,png,jpg,gif,pdf|max:2048',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 400);
        }

        // Check if a new photo is provided
        if ($request->hasFile('photo')) {
            // Delete the existing photo if it exists
            if ($game->photo) {
                Storage::delete('uploads/games_photo/' . $game->photo);
            }
            // Store the new photo
            $avatar = $request->file('photo');
            $photo = upload($avatar,public_path('uploads/games_photo/'));
        } else {
            $photo = $game->photo; // Retain the existing photo
        }

        $game->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'photo' => $photo,
            'status' => $request->has('status') ? $request->status : 1,
            'photo_description' => $request->photo_description,

        ]);
        if(  $game->photo){
             $game->photo = asset('uploads/games_photo/'. $game->photo)  ;
        }
        return response()->json(['successful' => true, 'data' =>    $game], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {

        if (!$game) {
            return response()->json(['message' => 'games not found'], 404);
        }
        if ($game->photo) {
            // Assuming 'personal_photo' is the attribute storing the file name
            $photoPath = 'uploads/games_photo/' . $game->photo;

            // Delete photo from storage
            Storage::delete($photoPath);
        }

        // Delete the user
        $game->delete();

        return response()->json(null, 200);
    }
    public function getGameCount()
    {
        $count = Game::count();

        return response()->json([
            "successful" => true,
            "message" => "عملية العرض تمت بنجاح",
            'data' => $count
        ]);
    }
}
