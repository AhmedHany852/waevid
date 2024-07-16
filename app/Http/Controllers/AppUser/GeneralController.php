<?php

namespace App\Http\Controllers\AppUser;

use App\Models\Game;
use App\Models\Service;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
    public function social_media(Request $request)
    {
        $socialMediaItems = SocialMedia::paginate($request->get('per_page', 50));
        foreach($socialMediaItems as $socialMediaItem){
            if(  $socialMediaItem->photo){
                $socialMediaItem->photo = asset('uploads/social_photo/'. $socialMediaItem->photo)  ;
              }
            }
            return response()->json($socialMediaItems);

    }
    public function services(Request $request)
    {
        $services = Service::paginate($request->get('per_page', 50));
        foreach($services as $service){
            if( $service->photo){
                $service->photo = asset('uploads/service_photo/'.$service->photo)  ;
            }
        }
        return response()->json(['successful' => true, 'data' =>    $services], 200);
    }
    public function games(Request $request)
    {
        $games = Game::paginate($request->get('per_page', 50));
        foreach($games as $game){
            if( $game->photo){
                $game->photo = asset('uploads/games_photo/'.$game->photo)  ;
            }
        }
        return response()->json(['successful ' => true, 'data' =>    $games], 200);
    }
}
