<?php

namespace App\Http\Controllers;

use App\Models\paypal;
use App\Http\Requests\StorepaypalRequest;
use App\Http\Requests\UpdatepaypalRequest;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\DB;
class PaypalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
      $paypaltoken=  $provider->getAccessToken();
      $response= $provider->createOrder(

       [ "intent"=> "CAPTURE",
       "application_context"=>[
        "return_url"=> route('success'),
    "cancel_url"=> route('paypal_cancel')
       ]
       ,"purchase_units"=> [
        [
            "amount"=>[
                 "currency_code"=> "USD",
          "value"=>  $request->price
            ]
        ]
       ]]
      );
      if (isset($response['id']) && $response['id']!=null) {
        foreach ($response['links'] as $link ) {
               if ($link['rel'] == "approve" ) {
                return redirect()->away($link['href']);
               } 
        }
      }else{
        return redirect()->route('paypal_cancel');
      }
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypaltoken =  $provider->getAccessToken();
        $response= $provider->capturePaymentOrder($request->token);
        if (isset($response['status']) && $response['status']== "COMPLETED") {

            DB::table('paypals')->insert([
                'paymen_id'=> $response['id'],
                'user_name' =>$response['payment_source']['paypal']['name']['given_name'] . $response['payment_source']['paypal']['name']['surname'],
                'user_email'=> $response['payment_source']['paypal']['email_address'],
                'payment_status'=> $response['payment_source']['paypal']['account_status'],
                'currency'=> 'USD',
                'amount'=> $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
                
            ]);
           return "paymeny seccc";
        }else{
            return redirect()->route('paypal_cancel');

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepaypalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepaypalRequest $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\paypal  $paypal
     * @return \Illuminate\Http\Response
     */
    public function show(paypal $paypal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\paypal  $paypal
     * @return \Illuminate\Http\Response
     */
    public function edit(paypal $paypal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepaypalRequest  $request
     * @param  \App\Models\paypal  $paypal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepaypalRequest $request, paypal $paypal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\paypal  $paypal
     * @return \Illuminate\Http\Response
     */
    public function destroy(paypal $paypal)
    {
        //
    }
}
