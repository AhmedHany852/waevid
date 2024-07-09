<?php

namespace App\Http\Controllers\AppUser;

use App\Models\Order;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Services\TabbyPayment;
use App\Services\paylinkPayment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public $paylink;
    public $tabby;
    public function __construct()
    {
        $this->paylink = new paylinkPayment();
        $this->tabby = new TabbyPayment();
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
            'social_media_id' => 'required|exists:social_media,id',
            'visites' => 'required|integer|min:100',
            'url' => 'nullable|url',
            'payment_method' => 'required|string',
        ]);
       $social_media =  SocialMedia::find($request->social_media_id);
        $PriceForOne = $social_media ->price / 100;
        $totalPrice =  $PriceForOne * $ $request->visites;
       $user =Auth::guard('app_users')->user();
       $order = Order::create([
            'user_id' => Auth::guard('app_users')->user()->id,
            'social_media_id' => $request->social_media_id,
            'visites' => $request->visites,
            'url' =>  $request->url,
            'total_price' => $totalPrice,
            'payment_method' =>  $request->payment_method,
        ]);
        if ($request->payment == 'Tabby') {
            $items = collect([]);
            $items->push([
                'title' => 'title',
                'quantity' => 2,
                'unit_price' => 20,
                'category' => 'Clothes',
            ]);;

            $order_data = [
                'amount' =>  $totalPrice,
                'currency' => 'SAR',
                'description' => 'description',
                'full_name' => $user->name ?? 'user_name',
                'buyer_phone' => $user->phone ?? '9665252123',
                //  'buyer_email' => 'card.success@tabby.ai',//this test
                  'buyer_email' =>  $user->email ?? 'user@gmail.com',
                'address' => 'Saudi Riyadh',
                'city' => 'Riyadh',
                'zip' => '1234',
                'order_id' => " $order->id",
                'registered_since' =>  $order->created_at,
                'loyalty_level' => 0,
                'success-url' => route('success-ur-subscription'),
                'cancel-url' => route('cancel-ur-subscription'),
                'failure-url' => route('failure-ur-subscription'),
                'items' =>  $items,
            ];

            $payment = $this->tabby->createSession($order_data);

            $id = $payment->id;

            $redirect_url = $payment->configuration->available_products->installments[0]->web_url;

            return  $redirect_url;
        }
        elseif ($request->payment == 'Paylink') {

            $data = [
                'amount' => $totalPrice,
                'callBackUrl' => route('paylink-result-subscription'),
                'clientEmail' => $user->email ?? 'test@gmail.com',
                'clientMobile' => $user->phone ?? '9665252123',
                'clientName' => $user->name ?? 'user_name',
                'note' => 'This invoice is for VIP client.',
                'orderNumber' => $order->id,
                'products' => [
                    [
                        'description' =>  $social_media->description ?? 'description',
                        'imageSrc' =>  null,
                        'price' => $totalPrice ?? 1,
                        'qty' => 1,
                        'title' =>  $social_media->name ?? 'title',
                    ],
                ],
            ];


            return $this->paylink->paymentProcess($data);
        }
        else{
            return response()->json(['message' => 'you need payment method'], 422);
        }

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
