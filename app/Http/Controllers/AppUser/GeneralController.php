<?php

namespace App\Http\Controllers\AppUser;

use App\Models\Game;
use App\Models\Service;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\OrderServiceGame;

class GeneralController extends Controller
{
    public function social_media(Request $request)
    {
        $socialMediaItems = SocialMedia::with('review')->paginate($request->get('per_page', 50));
        foreach($socialMediaItems as $socialMediaItem){
            if(  $socialMediaItem->photo){
                $socialMediaItem->photo = asset('uploads/social_photo/'. $socialMediaItem->photo)  ;
              }
            }
            return response()->json($socialMediaItems);

    }
    public function services(Request $request)
    {
        $services = Service::with('review')->paginate($request->get('per_page', 50));
        foreach($services as $service){
            if( $service->photo){
                $service->photo = asset('uploads/service_photo/'.$service->photo)  ;
            }
        }
        return response()->json(['successful' => true, 'data' =>    $services], 200);
    }
    public function games(Request $request)
    {
        $games = Game::with('review')->paginate($request->get('per_page', 50));
        foreach($games as $game){
            if( $game->photo){
                $game->photo = asset('uploads/games_photo/'.$game->photo)  ;
            }
        }
        return response()->json(['successful ' => true, 'data' =>    $games], 200);
    }
    public function showSocial($id)
    {
        $socialMedia = SocialMedia::findOrFail($id);

        if(  $socialMedia->photo){
            $socialMedia->photo = asset('uploads/social_photo/'. $socialMedia->photo)  ;
       }
        return response()->json($socialMedia);
    }
    public function showService(Service $service)
    {
        if( $service->photo){
            $service->photo = asset('uploads/service_photo/'.$service->photo)  ;
        }
        return response()->json(['successful' => true, 'data' =>    $service], 200);
    }
    public function showGame(Game $game)
    {
        if( $game->photo){
            $game->photo = asset('uploads/games_photo/'.$game->photo)  ;
        }
        return response()->json(['successful' => true, 'data' => $game], 200);
    }
    public function getSocialMostCommon(){
        $mostCommonSocialMedia = DB::table('orders')
        ->select('social_media_id', DB::raw('count(*) as total'))
        ->groupBy('social_media_id')
        ->orderBy('total', 'desc')
        ->get();

        return response()->json(['successful' => true, 'data' => $mostCommonSocialMedia], 200);

    }
    public function getServiceMostCommon(){
        $mostCommonService = OrderServiceGame::where('orderable_type', Service::class)
        ->select('orderable_id', DB::raw('count(*) as total'))
        ->groupBy('orderable_id')
        ->orderBy('total', 'desc')
        ->get();
        return response()->json(['successful' => true, 'data' => $mostCommonService], 200);

    }
    public function getGameMostCommon(){
        $mostCommonGame = OrderServiceGame::where('orderable_type', Game::class)
        ->select('orderable_id', DB::raw('count(*) as total'))
        ->groupBy('orderable_id')
        ->orderBy('total', 'desc')
        ->get();
        return response()->json(['successful' => true, 'data' => $mostCommonGame], 200);

    }
}
