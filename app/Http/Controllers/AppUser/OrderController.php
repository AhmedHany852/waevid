<?php

namespace App\Http\Controllers\AppUser;

use App\Models\Order;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        $request->validate([
            'social_media_id' => 'required|exists:social_media,id',
            'visites' => 'required|integer|min:100',
            'url' => 'nullable|url',
            'payment_method' => 'required|string',
        ]);
       $social=  SocialMedia::find($request->social_media_id);
        $PriceForOne = $social->price / 100;
        $totalPrice =  $PriceForOne * $ $request->visites;

        Order::create([
            'user_id' => Auth::guard('app_users')->user()->id,
            'social_media_id' => $request->social_media_id,
            'visites' => $request->visites,
            'url' =>  $request->url,
            'total_price' => $totalPrice,
            'payment_method' =>  $request->payment_method,
        ]);

        return redirect()->route('booked.index')
            ->with('success', 'Booked record created successfully.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
