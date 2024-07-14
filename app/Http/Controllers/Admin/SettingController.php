<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')
            ->toArray();
            $image = asset('uploads/settings/' .  $settings['site_logo_single']);
            $image2 = asset('uploads/settings/' .  $settings['site_logo_full']);
            $settings['site_logo_single'] =    $image;
            $settings['site_logo_full'] =    $image2;
        return  $settings;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            "site_logo_single"=> '',
           "site_logo_full"=> '',
            "site_name"=> '',
            "site_name_en"=> '',
            "info_email"=> '',
            "mobile"=> '',
            "tax_added_value"=> '',
            "tiktok"=> '',
            "instagram"=> '',
            "snapchat"=> '',
            "siteMaintenanceMsg"=> '',
            "maintenance_mode"=> '',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        foreach ($validator->validated() as $key => $input) {

            if (request()->hasFile('site_logo_single') && $request->file('site_logo_single')->isValid()) {

                $avatar = $request->file('site_logo_single');
                $image = upload($avatar, public_path('uploads/settings'));
                $input = $image;
            }
            if (request()->hasFile('site_logo_full') && $request->file('site_logo_full')->isValid()) {

                $avatar = $request->file('site_logo_full');
                $image = upload($avatar, public_path('uploads/settings'));
                $input = $image;
            }
            $settings =  Setting::updateOrCreate(
                [
                    'key' => $key,
                ],
                [
                    'value' => $input,
                ]
            );
        }
        $settings = Setting::pluck('value', 'key')
            ->toArray();

        $image = asset('uploads/settings/' .  $settings['site_logo']);
        $settings['site_logo'] =    $image;
        return response()->json(['isSuccess' => true, 'data' =>    $settings], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
