<?php

namespace App\Http\Controllers\AppUser;

use App\Models\Game;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\OrderServiceGame;
use App\Services\paylinkPayment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderServiceGameController extends Controller
{
    public $paylink;
    public function __construct()
    {
        $this->paylink = new paylinkPayment();

    }
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
            'orderable_id' => 'required|integer',
            'orderable_type' => 'required|string|in:service,game',
            'payment_method' => 'required|string'
        ]);

        $orderableType = $request->input('orderable_type') === 'service' ? Service::class : Game::class;
        $orderable = $orderableType::findOrFail($request->input('orderable_id'));
        $user = Auth::guard('app_users')->user();
        $order = new OrderServiceGame([
            'user_id' => Auth::guard('app_users')->user()->id,
            'total_price' => $orderable->price,
            'payment_method' => $request->input('payment_method')
        ]);

        $orderable->orders()->save($order);

        if ($request->payment_method == 'Paylink') {

            $data = [
                'amount' =>  $orderable->price,
                'callBackUrl' => route('paylink-result2'),
                'clientEmail' => $user->email ?? 'test@gmail.com',
                'clientMobile' => $user->phone ?? '9665252123',
                'clientName' => $user->name ?? 'user_name',
                'note' => 'This invoice is for VIP client.',
                'orderNumber' => $order->id,
                'products' => [
                    [
                        'description' =>  $orderable->description ?? 'description',
                        'imageSrc' =>  null,
                        'price' => $totalPrice ?? 1,
                        'qty' => 1,
                        'title' =>  $orderable->name ?? 'title',
                    ],
                ],
            ];


            return $this->paylink->paymentProcess($data);
        }
        else{
            return response()->json(['message' => 'you need payment method'], 422);
        }
    }

    public function paylinkResult2(Request $request)
    {

        return   $this->paylink->calbackPayment2($request);
    }
}
