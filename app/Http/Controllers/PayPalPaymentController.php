<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Order;
use App\Models\TempOrder;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
class PayPalPaymentController extends Controller
{

    /*
     * Paypal Gateway
     */
    public static function process($totalAmount)
    {
       
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
               
              env('PAYPAL_CLIENT_ID',''),
              env('PAYPAL_CLIENT_SECRET','')
            )
          );

       

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // Set redirect URLs
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal'))
        ->setCancelUrl(route('home'));

        
     // Set payment amount
        $amount = new Amount();
        $amount->setCurrency("USD")
        ->setTotal($totalAmount);
        
        // Set transaction object
        $transaction = new Transaction();
        $transaction->setAmount($amount)
        ->setDescription("Pay for Doctor Booking");

        // Create the full payment object
        $payment = new Payment();
        $payment->setIntent('sale')
        ->setPayer($payer)
        ->setRedirectUrls($redirectUrls)
        ->setTransactions(array($transaction));


                // Create payment with valid API context
        try {
            $payment->create($apiContext);
        
            // Get PayPal redirect URL and redirect the customer
            $approvalUrl = $payment->getApprovalLink();
        
            // Redirect the customer to $approvalUrl
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (\Exception $ex) {
            die($ex);
        }
       
        return $payment;
    }

    public function ipn()
    {

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                env('PAYPAL_CLIENT_ID',''),
                env('PAYPAL_CLIENT_SECRET','')
            )
          );

                // Get payment object by passing paymentId
        $paymentId = $_GET['paymentId'];
        $payment = Payment::get($paymentId, $apiContext);
        $payerId = $_GET['PayerID'];

        // Execute payment with payer ID
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
          
        try {
        // Execute payment
        $result = $payment->execute($execution, $apiContext);
            if($result->state == 'approved'){

                $order = Order::where('order_id',session('trx'))->first();
                $order->payment_status = 'Completed';
                $order->save();

                AppointmentController::orderBooked(session('trx'));

            }

            return redirect()->route('payment.success');

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
            } catch (\Exception $ex) {
            die($ex);
        }
    }

}