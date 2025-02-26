<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\Payment; // Import the Payment model
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'payment_id' => 'required|string',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'status' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'task_id' => 'required|exists:tasks,id',
        ]);

        // Create a new payment record
        $payment = Payment::create([
            'payment_id' => $request->payment_id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'status' => $request->status,
            'user_id' => $request->user_id,
            'task_id' => $request->task_id,
        ]);

        return response()->json($payment, 201); // Return the created payment
    }
}