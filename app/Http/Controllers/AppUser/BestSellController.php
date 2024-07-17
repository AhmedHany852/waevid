<?php

namespace App\Http\Controllers\AppUser;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Service;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class BestSellController extends Controller
{
    public function bestSellServices()
    {
        $bestSellServices = Service::orderByDesc('price')
            ->where('status', 1)
            ->limit(5)
            ->get();

        return response()->json([
            'message' => 'Best-selling services',
            'data' => $bestSellServices
        ]);
    }

    /**
     * Get the best-selling games.
     *
     * @return \Illuminate\Http\Response
     */
    public function bestSellGames()
    {
        $bestSellGames = Game::orderByDesc('price')
            ->where('status', 1)
            ->limit(5)
            ->get();

        return response()->json([
            'message' => 'Best-selling games',
            'data' => $bestSellGames
        ]);
    }
    public function bestSellSocialMedia()
    {
        $bestSellSocialMedia = SocialMedia::orderByDesc('price')
            ->where('status', 1)
            ->limit(5)
            ->get();

        return response()->json([
            'message' => 'Best-selling social media products',
            'data' => $bestSellSocialMedia
        ]);
    }
}