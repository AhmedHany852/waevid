<?php

namespace App\Http\Controllers\AppUser;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:app_users,id',
            'reviewable_type' => 'required|string',
            'reviewable_id' => 'required|integer',
            'descriptions' => 'nullable|string',
            'rating' => 'required|numeric|between:1,5',
        ]);
        $reviewableType = $request->input('reviewable_type') === 'service' ? Service::class : Game::class;
        $reviewable = $reviewableType::findOrFail($request->input('reviewable_id'));

        // Create a new review
        $review = Review::create([
            'user_id' => $request->user_id,
            'reviewable_type' => $reviewableType,
            'reviewable_id' => $reviewable,
            'descriptions' => $request->descriptions,
            'rating' => $request->rating,
        ]);

        // Return a response
        return response()->json(['successful ' => true, 'data' =>    $review], 200);
    }
}