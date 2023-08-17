<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use Facades\App\Services\BasicCurl;
use Facades\App\Services\BasicService;
use Illuminate\Http\Request;

class khaltiPaymentController extends Controller
{

    public function verifyPayment(Request $request, $trx)
    {
        $order = Fund::with('gateway')->where("transaction",$trx)->first();
        if(!$order){
            session()->flash('error','Invalid Khalti Payment Request');
            return back(url('/'));
        }
        $gateway = $order->gateway;
        $token = $request->token;
        $args = http_build_query(array(
            'token' => $token,
            'amount'  => round($order->final_amount)*100
        ));
        $url = "https://khalti.com/api/v2/payment/verify/";
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $secret_key = $gateway->parameters->secret_key ?? '';

        $headers = ["Authorization: Key $secret_key"];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $response;
    }

    public function storePayment(Request $request)
    {
        $result =   $request->all();
        $transaction =  json_decode($result['response'])->product_identity;
        $order = Fund::where("transaction",$transaction)->orderBy('id','desc')->first();
        if($order){
            BasicService::preparePaymentUpgradation($order);
        }
    }
}
