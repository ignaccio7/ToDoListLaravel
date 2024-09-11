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
        return view('task.index', compact('tasks'));
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(task $task)
    {
        //
    }
}
