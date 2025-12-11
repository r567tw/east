<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoutineTask;
use Illuminate\Http\Request;

class RoutineTaskController extends Controller
{
    // 取得所有 routine tasks
    public function index()
    {
        return response()->json(RoutineTask::all());
    }

    // 新增 routine task
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'weeks_of_month' => 'required|integer|min:1|max:5',
            'day_of_week' => 'required|integer|min:0|max:6',
            'active' => 'boolean',
        ]);
        $task = RoutineTask::create($data);

        return response()->json($task, 201);
    }

    // 取得單一 routine task
    public function show($id)
    {
        $task = RoutineTask::find($id);
        if (! $task) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json($task);
    }

    // 更新 routine task
    public function update(Request $request, $id)
    {
        $task = RoutineTask::find($id);
        if (! $task) {
            return response()->json(['error' => 'Not found'], 404);
        }
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'weeks_of_month' => 'sometimes|required|integer|min:1|max:5',
            'day_of_week' => 'sometimes|required|integer|min:0|max:6',
            'active' => 'boolean',
        ]);
        $task->update($data);

        return response()->json($task);
    }

    // 刪除 routine task
    public function destroy($id)
    {
        $task = RoutineTask::find($id);
        if (! $task) {
            return response()->json(['error' => 'Not found'], 404);
        }
        $task->delete();

        return response()->json(['success' => true]);
    }
}
