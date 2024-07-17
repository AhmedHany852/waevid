<?php

namespace App\Http\Controllers\AppUser;

use App\Models\Game;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'reviewable_type' => 'required|string',
        'reviewable_id' => 'required|integer',
        'descriptions' => 'nullable|string',
        'rating' => 'required|numeric|between:1,5',
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
    }

    $reviewableType = $request->input('reviewable_type') === 'service' ? Service::class : Game::class;
    $reviewable = $reviewableType::findOrFail($request->input('reviewable_id'));

    // Create a new review
    $review = Review::create([
        'user_id' => Auth::guard('app_users')->user()->id,
        'reviewable_type' => $reviewableType,
        'reviewable_id' => $reviewable->id,
        'descriptions' => $request->descriptions,
        'rating' => $request->rating,
    ]);

    // Return a response
    return response()->json(['success' => true, 'data' => $review], 200);
}
public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'reviewable_type' => 'required|string',
        'reviewable_id' => 'required|integer',
        'descriptions' => 'nullable|string',
        'rating' => 'required|numeric|between:1,5',
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
    }
    $review = Review::findOrFail($id);

    $reviewableType = $request->input('reviewable_type') === 'service' ? Service::class : Game::class;
    $reviewable = $reviewableType::findOrFail($request->input('reviewable_id'));
    $review->update([
        'reviewable_type' => $reviewableType,
        'reviewable_id' => $reviewable->id,
        'descriptions' => $request->descriptions,
        'rating' => $request->rating,
    ]);
    return response()->json(['success' => true, 'data' => $review], 200);
}
public function destroy($id)
{
    $review = Review::findOrFail($id);
    $review->delete();
    return response()->json(['success' => true, 'message' => 'Review deleted successfully'], 200);
}

}
