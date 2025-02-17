<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Verify PayPal payment
    public function verifyPayment(Request $request)
    {
        $paymentId = $request->input('payment_id');

        // Call PayPal API to verify payment
        // This is a placeholder; you need to implement PayPal API integration
        $isPaymentValid = $this->verifyPayPalPayment($paymentId);

        if (!$isPaymentValid) {
            return response()->json(['error' => 'Payment failed'], 400);
        }

        // Store payment details in the database
        $payment = Payment::create([
            'payment_id' => $paymentId,
            'amount' => $request->input('amount'),
            'currency' => 'USD',
            'status' => 'completed',
            'user_id' => $request->input('user_id'),
            'task_id' => $request->input('task_id'),
        ]);

        return response()->json(['message' => 'Payment successful', 'payment' => $payment]);
    }

    private function verifyPayPalPayment($paymentId)
    {
        // Implement PayPal API logic here
        // For now, return true for testing
        return true;
    }
}