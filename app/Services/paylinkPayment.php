<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Point;
use App\Models\Coupon;
use App\Models\Booking;
use App\Models\Membership;
use App\Events\BookedEvent;
use App\Models\OrderPayment;
use App\Models\OrderServiceGame;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\PaymentGetway;
use App\Models\PaymentGeteway;
use Illuminate\Support\Facades\DB;
use App\Models\SubscriptionPayment;
use App\Services\WatsapIntegration;
use App\Notifications\AppUserBooking;
use App\Notifications\BookingNotification;
use Illuminate\Support\Facades\Notification;
use App\Services\WatsapIntegrationSubscription;


class paylinkPayment
{
    public $client;
    public function __construct()
    {

        // $paylink = PaymentGetway::where([
        //     ['keyword', 'Paylink'],
        // ])->first();
        // $paylinkConf = json_decode($paylink->information, true);
        // Config::set('services.paylink.pk_test ',$paylinkConf["app_id"]);
        // Config::set('services.paylink.app_secret  ',$paylinkConf["app_secret"]);
        // $client = new \Paylink\Client([ //this is for testing
        //     'vendorId'  =>  'APP_ID_1123453311',
        //     'vendorSecret'  =>  '0662abb5-13c7-38ab-cd12-236e58f43766',

        // ]);

        $client = new \Paylink\Client([
            'vendorId'  =>  'APP_ID_1710162901464',
            'vendorSecret'  =>  'f29394fd-37fd-3ee7-a4f7-ea6014a24146',
            'environment'  =>  'prod',

        ]);
        $this->client = $client;
    }
    public function paymentProcess($data)
    {

        $response =  $this->client->createInvoice($data);

        return    $response['mobileUrl'];
    }


    public function calbackPayment(Request $request)
    {
        $response =  $this->client->getInvoice($request->transactionNo);

        if ($response['orderStatus'] == 'Paid') {
            try {
                DB::beginTransaction();
                $order = Order::where('id', $response->order->reference_id)->first();
                $order_payment =   OrderPayment::create([
                    'payment_type' => 'Paylink',
                    'customer_name' => $response['gatewayOrderRequest']['clientName'],
                    'transaction_id' => $request->transactionNo,
                    'transaction_url' =>  $response['mobileUrl'],
                    'order_id' =>  $order->id,
                    'price' =>   $response['amount'],
                    'transaction_status' => $response['orderStatus'],
                    'is_success' => $response['success'],
                    'transaction_date' => $response['paymentReceipt']['paymentDate'],
                ]);
                DB::commit();
                return response()->json(['message' => 'payment created successfully'], 201);
            } catch (\Throwable $th) {
                dd($th->getMessage(), $th->getLine());
                DB::rollBack();
                return response()->json(["error" => 'error', 'Data' => 'payment failed'], 404);
            }
        }
    }
    public function calbackPayment2(Request $request)
    {
        $response =  $this->client->getInvoice($request->transactionNo);

        if ($response['orderStatus'] == 'Paid') {
            try {
                DB::beginTransaction();
                $order = OrderServiceGame::where('id', $response->order->reference_id)->first();
                $order_payment =   OrderPayment::create([
                    'payment_type' => 'Paylink',
                    'customer_name' => $response['gatewayOrderRequest']['clientName'],
                    'transaction_id' => $request->transactionNo,
                    'transaction_url' =>  $response['mobileUrl'],
                    'order_service_games_id' =>  $order->id,
                    'price' =>   $response['amount'],
                    'transaction_status' => $response['orderStatus'],
                    'is_success' => $response['success'],
                    'transaction_date' => $response['paymentReceipt']['paymentDate'],
                ]);
                DB::commit();
                return response()->json(['message' => 'payment created successfully'], 201);
            } catch (\Throwable $th) {
                dd($th->getMessage(), $th->getLine());
                DB::rollBack();
                return response()->json(["error" => 'error', 'Data' => 'payment failed'], 404);
            }
        }
    }
}
