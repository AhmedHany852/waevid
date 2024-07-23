<?php

namespace App\Http\Controllers\AppUser;

use App\Models\AppUsers;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AppUserResource;
use App\Http\Resources\ApartmentResource;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('app_users')->user();
        if ($user->image) {
            $user->image = asset('uploads/user/' .  $user->image);
        }
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        return response()->json(['data' =>  $user], 200);
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('app_users')->user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->phone = "009665" . $request->phone;
        if (request()->has('image') &&  request('image') != '') {
            $avatar = request()->file('image');
            if ($avatar->isValid()) {
                $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatarPath = public_path('/uploads/user');
                $avatar->move($avatarPath, $avatarName);
                $image  = $avatarName;
            }
        } else {
            $image = $user->image;
        }
        $user->image = $image;
        $user->save();

        return response()->json(['message' => 'Profile updated successfully', 'data' => new  AppUserResource($user) ]);
    }
    public  function deactive_account(Request $request)
    {
        $user = Auth::guard('app_users')->user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        if ($user) {
            $user->status = 0;
            $user->save();
            return response()->json(['success' => "true"], 200);
        } else {
            return response()->json(['error' => "you do not have access"], 200);
        }
    }
}
