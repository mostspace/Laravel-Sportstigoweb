<?php

namespace App\Http\Controllers;
use SenangPay\SenangPay;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
  
  
         /* public function processorder(Request $request)
          {
            
                  
                    $merchantId = '644166729208395';
                    $secretKey = '37411-927';
                  
                    $senangPay = new SenangPay($merchantId, $secretKey);
                    $paymentUrl = $senangPay->createPayment(
                      'SportstigoApplication',
                      1000,
                      56,
                      [
                        'name' => 'TestingUser',
                        'email' => 'vendor230@sportstigo.com',
                        'phone' => '011223344'
                      ]
                    );

                    return $paymentUrl;

                    //$callbackurl = $senangPay->callback();

                    

        }*/
}

