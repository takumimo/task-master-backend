<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
{
    $tasks = Task::where('user_id', $request->user()->id)->get();
    return response()->json($tasks);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'due_date' => 'required|date',
    ]);

    $task = new Task($validated);
    $task->user_id = $request->user()->id;
    $task->save();

    return response()->json($task, 201);
}

public function update(Request $request, Task $task)
{
    $validated = $request->validate([
        'name' => 'string|max:255',
        'due_date' => 'date',
        'completed' => 'boolean',
    ]);

    $task->fill($validated)->save();

    return response()->json($task);
}

public function destroy(Task $task)
{
    $task->delete();
    return response()->json(null, 204);
}
}
