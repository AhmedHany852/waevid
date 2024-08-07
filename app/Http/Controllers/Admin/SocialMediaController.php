<?php

namespace App\Http\Controllers\Admin;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $socialMediaItems = SocialMedia::paginate($request->get('per_page', 50));
        foreach($socialMediaItems as $socialMediaItem){
        if(  $socialMediaItem->photo){
            $socialMediaItem->photo = asset('uploads/social_photo/'. $socialMediaItem->photo)  ;
          }
        }
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
            'visites_minimum' => 'required|integer|min:0',
            'url_description' => 'nullable|string',
            'speed_description' => 'nullable|string',
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
            $photo = upload($avatar,public_path('uploads/social_photo/'));
        } else {
            $photo = null;
        }

        $visitesMinimum = $request->visites_minimum;

        $socialMedia = SocialMedia::create([
            'photo' => $photo,
            'price' => $request->price,
            'price_description' => $request->price_description,
            'description' => $request->description,
            'status' => $request->status,
            'visites_minimum' =>  $visitesMinimum ?? 100,
            'url_description' => $request->url_description,
            'speed_description' => $request->speed_description,
            'name' => $request->name,
            'photo_description' => $request->photo_description,
            'minimum_order' => $request->minimum_order ?? 1,
        ]);
        if(  $socialMedia->photo){
            $socialMedia->photo = asset('uploads/social_photo/'. $socialMedia->photo)  ;
       }
        return response()->json($socialMedia, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $socialMedia = SocialMedia::findOrFail($id);
        if(  $socialMedia->photo){
            $socialMedia->photo = asset('uploads/social_photo/'. $socialMedia->photo)  ;
       }
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
            'price_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|max:255',
            'visites_minimum' => 'nullable|integer|min:0',
            'url_description' => 'nullable|string',
            'speed_description' => 'nullable|string',
            'photo_description' => 'nullable|string',
            'minimum_order' => 'nullable|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 400);
        }
        $socialMedia = SocialMedia::findOrFail($id);
        if ($request->hasFile('photo')) {
            if ($socialMedia->photo) {
                Storage::delete('uploads/social_photo/' . $socialMedia->photo);
            }
            $avatar = $request->file('photo');
            $photo = upload($avatar,public_path('uploads/social_photo/'));
        } else {
            $photo =  $socialMedia->photo;
        }

        $visitesMinimum = $request->visites_minimum;
        // Create a new social media item with total_price
        $socialMedia->update([
            'photo' => $photo,
            'price' => $request->price,
            'price_description' => $request->price_description,
            'description' => $request->description,
            'status' => $request->status,
            'visites_minimum' => $visitesMinimum ?? 100,
            'url_description' => $request->url_description,
            'speed_description' => $request->speed_description,
            'name' => $request->name,
            'photo_description' => $request->photo_description,
            'minimum_order' => $request->minimum_order ?? 1,
        ]);
        if(  $socialMedia->photo){
             $socialMedia->photo = asset('uploads/social_photo/'. $socialMedia->photo)  ;
        }
        return response()->json($socialMedia, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $socialMedia = SocialMedia::findOrFail($id);
        $socialMedia->delete();
        return response()->json(null, 200);
    }
    public function SocialCount()
    {
        $count = SocialMedia::count();

        return response()->json([
            "successful" => true,
            "message" => "عملية العرض تمت بنجاح",
            'data' => $count
        ]);
    }
}
