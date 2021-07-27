<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\TempOrder;


class PayPalPaymentController extends Controller
{

    /*
     * Paypal Gateway
     */
    public static function process($paypalConfig , $trx, $request)
    {
        $paypalAcc = json_decode(json_encode($paypalConfig));

        $orders = TempOrder::where('temp_trx', $trx)->get();

        $totalAmount = $orders->sum('amount');

       

        $val['cmd'] = '_xclick';
        $val['business'] = trim($paypalAcc->paypal_email);
        $val['cbt'] = 'test';
        $val['currency_code'] = "USD";
        $val['quantity'] = 1;
        $val['item_name'] = "Payment To test Account";
        $val['custom'] = "$trx";
        $val['amount'] = round($totalAmount,2);
        $val['return'] = route('payment.success');
        $val['cancel_return'] = route('home');
        $val['notify_url'] = route('paypal');
        $send['val'] = $val;
        $send['view'] = 'paypal';
        $send['method'] = 'post';
        $send['url'] = 'https://www.sandbox.paypal.com/';


        return json_encode($send);
    }

    public function ipn()
    {

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        $req = 'cmd=_notify-validate';
        foreach ($myPost as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
            $details[$key] = $value;
        }
        
        $paypalURL = "https://ipnpb.sandbox.paypal.com/cgi-bin/webscr?"; // use for sandbox text
        // $paypalURL = "https://ipnpb.paypal.com/cgi-bin/webscr?";
        $callUrl = $paypalURL . $req;
        $verify = $this->curlContent($callUrl);
        
        if ($verify == "VERIFIED") {
            $order = Order::where('order_id', $_POST['custom'])->orderBy('id', 'DESC')->first();
            $order->payment_status = 'completed';
            $order->save();

            if ($order->payment_status == 'completed') {
                AppointmentController::orderBooked($order->order_id);
            }
        }
    }

    private function curlContent($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }

}