<?php

namespace App\Http\Controllers\Front;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function index(Request $request, $bookingId)
    {
        $booking = Booking::with(['item.brand', 'item.type'])->findOrFail($bookingId);

        return view('payment', [
            'booking' => $booking
        ]);
    }

    public function detail(Request $request, $bookingId)
    {
        $booking = Booking::with(['item.brand', 'item.type'])->findOrFail($bookingId);

        return view('payment-detail', [
            'booking' => $booking
        ]);
    }

    public function update(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->payment_method = $request->payment_method;

        if ($request->payment_method == 'midtrans') {
            // Call Midtrans API
            \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
            \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
            \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');

            // Get USD to IDR rate using guzzle
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'https://api.exchangerate-api.com/v4/latest/USD');
            $body = $response->getBody();
            $rate = json_decode($body)->rates->IDR;

            // Convert to IDR
            $totalPrice = $booking->total_price * $rate;

            // Create Midtrans Params
            $midtransParams = [
                'transaction_details' => [
                    'order_id' => $booking->id,
                    'gross_amount' => (int) $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => $booking->customer_name,
                    'email' => $booking->customer_email,
                ],
                'enabled_payments' => ['gopay', 'bank_transfer'],
                'vtweb' => []
            ];



            // Get Snap Payment Page URL
            $paymentUrl = \Midtrans\Snap::createTransaction($midtransParams)->redirect_url;

            // Save payment URL to booking
            $booking->payment_url = $paymentUrl;
            $booking->save();

            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        }

        return redirect()->route('front.index');
    }

    public function success(Request $request)
    {
        return view('success');
    }
}
