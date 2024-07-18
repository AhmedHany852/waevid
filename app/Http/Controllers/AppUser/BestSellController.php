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
            foreach($bestSellServices as $service){
                if( $service->photo){
                    $service->photo = asset('uploads/service_photo/'.$service->photo)  ;
                }
            }
        return response()->json([
            'message' => 'Best-selling services',
            'data' => $bestSellServices
        ]);
    }


    public function bestSellGames()
    {
        $bestSellGames = Game::orderByDesc('price')
            ->where('status', 1)
            ->limit(5)
            ->get();
            foreach($bestSellGames as $game){
                if( $game->photo){
                    $game->photo = asset('uploads/games_photo/'.$game->photo)  ;
                }
            }
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
            foreach($bestSellSocialMedia as $socialMediaItem){
                if(  $socialMediaItem->photo){
                    $socialMediaItem->photo = asset('uploads/social_photo/'. $socialMediaItem->photo)  ;
                  }
                }
        return response()->json([
            'message' => 'Best-selling social media products',
            'data' => $bestSellSocialMedia
        ]);
    }
}
