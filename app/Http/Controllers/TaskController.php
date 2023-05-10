<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        // return response()->json('task index');
        // return Task::all();
        return TaskResource::collection(
            Task::where('user_id', Auth::user()->id)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $req): TaskResource
    {
        $req->validated($req->all());

        $task = Task::create([
            'user_id' => Auth::user()->id,
            'name' => $req->name,
            'description' => $req->description,
            'priority' => $req->priority
        ]);

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): TaskResource | JsonResponse
    {
        if (Auth::user()->id !== $task->user_id) {
            return $this->error([], 'You are not authorized to make this request', 403);
        }
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
