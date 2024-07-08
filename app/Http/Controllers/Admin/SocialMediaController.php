<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $socialMediaItems = SocialMedia::paginate($request->get('per_page', 50));
        return response()->json($socialMediaItems);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'photo' => 'nullable',
            'price_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|max:255',
            'visites' => 'required|integer|min:0',
            'visites_minimum' => 'required|integer|min:0',
            'url_description' => 'nullable|string',
            'speed_description' => 'nullable|string',
            'url' => 'required|string|max:255',
            'photo_description' => 'nullable|string',
            'minimum_order' => 'nullable|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 400);
        }
        if ($request->file('photo')) {
            $avatar = $request->file('photo');
            $avatar->store('uploads/games_photo/', 'public');
            $photo = $avatar->hashName();
        } else {
            $photo = null;
        }

        $visites = $request->visites;
        //$visitesMinimum = $request->visites_minimum;

        // if ($visites >= $visitesMinimum) {
        //     return response()->json(['error' => 'The number of visits must be greater than or equal to the minimum visits.'], 422);
        // }

        // Calculate total_price
        // $PriceForOne = $request->price / $request->visites;
        // $totalPrice =  $PriceForOne  * $request->visites;
        $pricePerVisit = $request->price / 100;
        $totalPrice = $pricePerVisit * $visites;

        // Create a new social media item with total_price
        $socialMedia = SocialMedia::create([
            'photo' => $photo,
            'price' => $request->price,
            'price_description' => $request->price_description,
            'description' => $request->description,
            'status' => $request->status,
            'visites' => $request->visites ?? 100,
            'visites_minimum' => $request->visites_minimum ?? 100,
            'url_description' => $request->url_description,
            'speed_description' => $request->speed_description,
            'total_price' => $totalPrice,
            'name' => $request->name,
            'url' => $request->url,
            'photo_description' => $request->photo_description,
            'minimum_order' => $request->minimum_order ?? 1,
        ]);

        return response()->json($socialMedia, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $socialMedia = SocialMedia::findOrFail($id);
        return response()->json($socialMedia);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'photo' => 'nullable|string|max:255',
            'price_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|max:255',
            'visites' => 'nullable|integer|min:0',
            'visites_minimum' => 'nullable|integer|min:0',
            'url_description' => 'nullable|string',
            'speed_description' => 'nullable|string',
            'url' => 'nullable|string|max:255',
            'photo_description' => 'nullable|string',
            'minimum_order' => 'nullable|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 400);
        }
        $socialMedia = SocialMedia::findOrFail($id);

        if ($request->file('photo')) {
            $avatar = $request->file('photo');
            $avatar->store('uploads/games_photo/', 'public');
            $photo = $avatar->hashName();
        } else {
            $photo =  $socialMedia->photo;
        }
        // Ensure visites is greater than or equal to visites_minimum
        $visites = $request->visites;
        $visitesMinimum = $request->visites_minimum;

        // if ($visites <= $visitesMinimum) {
        //     return response()->json(['error' => 'The number of visits must be greater than or equal to the minimum visits.'], 422);
        // }
        // Calculate total_price
        $PriceForOne = $request->price / 100;
        $totalPrice =  $PriceForOne * $visites;

        // Create a new social media item with total_price
        $socialMedia = SocialMedia::create([
            'photo' => $photo,
            'price' => $request->price,
            'price_description' => $request->price_description,
            'description' => $request->description,
            'status' => $request->status,
            'visites' => $request->visites ?? 100,
            'visites_minimum' => $request->visites_minimum ?? 100,
            'url_description' => $request->url_description,
            'speed_description' => $request->speed_description,
            'total_price' => $totalPrice,
            'name' => $request->name,
            'url' => $request->url,
            'photo_description' => $request->photo_description,
            'minimum_order' => $request->minimum_order ?? 1,
        ]);

        return response()->json($socialMedia, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $socialMedia = SocialMedia::findOrFail($id);
        $socialMedia->delete();
        return response()->json(null, 204);
    }
}
