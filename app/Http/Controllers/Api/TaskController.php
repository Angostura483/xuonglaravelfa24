<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($projectId)
    {
        $tasks = Task::where('project_id', $projectId)->get();
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $projectId)
    {
        $task = Task::create([
            'project_id' => $projectId,
            'task_name' => $request->task_name,
            'description' => $request->description,
            'status' => $request->status
        ]);
        return response()->json(['message' => 'Nhiệm vụ được tạo', 'task' => $task]);
    }

    /**
     * Display the specified resource.
     */
    public function show($projectId, $taskId)
    {
        $task = Task::where('project_id', $projectId)->where('id', $taskId)->firstOrFail();
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $projectId, $taskId)
    {
        $task = Task::where('project_id', $projectId)->where('id', $taskId)->firstOrFail();
        $task->update($request->all());
        return response()->json(['message' => 'Nhiệm vụ được cập nhật', 'task' => $task]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($projectId, $taskId)
    {
        Task::where('project_id', $projectId)->where('id', $taskId)->delete();
        return response()->json(['message' => 'Nhiệm vụ được xóa']);
    }
}
