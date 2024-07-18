<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use App\Models\Order;
use App\Models\Booking;
use App\Models\Service;
use App\Models\AppUsers;
use App\Models\Membership;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use App\Models\OrderServiceGame;
use App\Models\SubscriptionPayment;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function all_orders_social_media()
    {
        $orders =  Order::with('socialMedias')->get();
        return response()->json(['data'=> $orders], 200);

    }
    public function all_orders_service()
    {
        $orders = OrderServiceGame::where('orderable_type', Service::class)
        ->orWhere('orderable_type', Game::class)
        ->with('orderable')
        ->get();
        return response()->json(['data'=> $orders], 200);

    }
    public function all_orders_games()
    {
        $orders = OrderServiceGame::Where('orderable_type', Game::class)
        ->with('orderable')
        ->get();
        return response()->json(['data'=> $orders], 200);

    }
    public function all_payments()
    {
        $payments = OrderPayment::with('order')->latest()->get();
        return response()->json(['data'=> $payments], 200);
    }

}
