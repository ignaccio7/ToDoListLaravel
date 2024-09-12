<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tasks = Task::all();
        return view('task.index');
    }

    public function listOfTasks()
    {
        // return response()->json(auth()->user());                
        $userId = auth()->user()->id;

        $tasks = Task::where('user_id', $userId)->get();
        return ($tasks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // return $request->all();
        //        
        if(!auth()->user()){
            return response()->json(['error' => 'You must be logged in to create a task'], 401); // Código 401 Unauthorized
        }

        $userId = auth()->user()->id;        
        
        $task = new Task();
        $task->task = $request->task;
        $task->user_id = $userId;
        $task->save();
        
        return $task;
        return redirect()->back();
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Task $task)
    {
        if(!auth()->user()){
            return response()->json(['error' => 'You must be logged in to create a task'], 401); // Código 401 Unauthorized
        }

        $userId = auth()->user()->id;

        $task = Task::find($task->id);

        if(!$task){
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->task = $request->task;
        $task->user_id = $userId;
        $task->save();

        return response()->json([compact('task'), 'message' => 'Task updated successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($task)
    {
        if(!auth()->user()){
            return response()->json(['error' => 'You must be logged in to create a task'], 401); // Código 401 Unauthorized
        }

        $task = Task::find($task);
        if(!$task){
            return response()->json(['error' => 'TAsk not found'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted successfully'], 200);
    }

    public function changeStatus($task) {
        return $task;

        $task = Task::find($task);        
        $task->status = '1';
    }

    private function validateToken($token)
    {
        if(!auth()->user()){
            return false;
        }
        return true;
    }
}
