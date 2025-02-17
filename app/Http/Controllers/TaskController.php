<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Get all tasks
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    // Create a new task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'payment_id' => 'required',
        ]);

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'status' => 'completed', // Mark as completed after payment
            'payment_id' => $validated['payment_id'],
        ]);

        return response()->json($task, 201);
    }
}