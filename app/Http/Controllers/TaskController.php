<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Get all tasks
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())->get();
        return response()->json($tasks);
    }

    // Create a new task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'user_id' => auth()->id(),
            //'status' => 'pending', // Mark as completed after payment
            
        ]);

        return response()->json($task, 201);
    }

    public function updateStatus(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'status' => 'required|string|in:pending,completed', // Adjust the statuses as needed
        ]);

        // Find the task by ID
        $task = Task::findOrFail($id);

        // Update the task's status
        $task->status = $request->input('status');
        $task->save(); // Save the changes to the database

        // Return a response
        return response()->json([
            'message' => 'Task status updated successfully.',
            'task' => $task, // Optionally return the updated task
        ], 200);
    }
}