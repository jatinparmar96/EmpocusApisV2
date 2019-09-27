<?php

namespace App\Api\V1\Controllers\CRM;

use App\Models\Crm\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::with(['lead'])->paginate();
        return response()->json([
            'status' => true,
            'data' => $tasks,
            'message' => 'Tasks retrieved Successfully'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            if ($request->id == 'new') {
                $lead = $this->store($request);
                return response()->json([
                    'status' => true,
                    'data' => $lead,
                    'message' => 'Task Stored Successfully'
                ], 201);
            } else {
                $lead = $this->update($request, $request->id);
                return response()->json([
                    'status' => true,
                    'data' => $lead,
                    'message' => 'Task Updated Successfully'
                ]);
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            if (env('APP_DEBUG')) {
                return response()->json([
                    'status' => false,
                    'error' => $e->getMessage(),
                    'message' => 'Something Went Wrong',
                    'full_error' => $e
                ], 500);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Something Went Wrong'
                ], 500);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = new Task();
        $task = $this->populateModel($task,$request);
        $task->save();
        return $task;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Crm\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Crm\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Crm\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Crm\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }

    function populateModel(Task $task, Request $request)
    {
        $task->due_date = $request->due_date;
        $task->description = $request->description;
        $task->lead_id = $request->lead_id;
        $task->is_done = false;

        $task->created_by = \Auth::user()->id;
        $task->updated_by = \Auth::user()->id;
        return $task;
    }
    public function markDone($task){
        $task = Task::findOrFail($task);
        $task->is_done = 1;
        $task->save();
        return response()->json([
            'status' => true,
            'data' => $task,
            'message' => 'Task Updated Successfully'
        ]);
    }
}
