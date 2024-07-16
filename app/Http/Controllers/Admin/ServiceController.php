<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $services = Service::paginate($request->get('per_page', 50));
        foreach($services as $service){
            if( $service->photo){
                $service->photo = asset('uploads/service_photo/'.$service->photo)  ;
            }
        }
        return response()->json(['successful' => true, 'data' =>    $services], 200);
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
            'status' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 400);
        }
        if ($request->file('photo')) {
            $avatar = $request->file('photo');
            $photo = upload($avatar,public_path('uploads/service_photo/'));
        } else {
            $photo = null;
        }
        $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'photo' => $photo,
            'status' => $request->status,
            'photo_description' => $request->photo_description,

        ]);
        if( $service->photo){
            $service->photo = asset('uploads/service_photo/'.$service->photo)  ;
        }
        // return response()->json(['message' => 'service created successfully', 'data' => $service], 200);
        return response()->json(['successful' => true, 'data' =>    $service], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        if( $service->photo){
            $service->photo = asset('uploads/service_photo/'.$service->photo)  ;
        }
        return response()->json(['successful' => true, 'data' =>    $service], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpeg,webp,png,jpg,gif,pdf|max:2048',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 400);
        }

        // Check if a new photo is provided
        if ($request->hasFile('photo')) {
            // Delete the existing photo if it exists
            if ($service->photo) {
                Storage::delete('uploads/service_photo/' . $service->photo);
            }
            // Store the new photo
            $avatar = $request->file('photo');
            $photo = upload($avatar,public_path('uploads/service_photo/'));
        } else {
            $photo = $service->photo; // Retain the existing photo
        }

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'photo' => $photo,
            'status' => $request->has('status') ? $request->status : 1,
            'photo_description' => $request->photo_description,

        ]);
        if( $service->photo){
            $service->photo = asset('uploads/service_photo/'.$service->photo)  ;
        }
        return response()->json(['successful' => true, 'data' =>    $service], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // Check if the service exists
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }
        if ($service->photo) {
            // Assuming 'personal_photo' is the attribute storing the file name
            $photoPath = 'uploads/service_photo/' . $service->photo;

            // Delete photo from storage
            Storage::delete($photoPath);
        }

        // Delete the user
        $service->delete();

        return response()->json(null, 200);
    }
    public function getServiceCount()
    {
        $count = Service::count();

        return response()->json([
            "successful" => true,
            "message" => "عملية العرض تمت بنجاح",
            'data' => $count
        ]);
    }
}
