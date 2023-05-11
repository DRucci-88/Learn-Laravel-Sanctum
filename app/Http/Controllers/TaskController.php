<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
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
        return $this->isAuthorized($task) ? new TaskResource($task) : $this->notAuthorizedResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        if (Auth::user()->id !== $task->user_id) {
            return $this->error([], 'You are not authorized to make this request', 403);
        }
        $task->update($request->all());
        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): ResponseFactory | JsonResponse | Response
    {
        // TODO How to handle no model found [404]
        if (!$this->isAuthorized($task)) {
            return $this->notAuthorizedResponse();
        }
        $task->delete();
        return response(null, 204);
    }

    private function isAuthorized(Task $task): bool
    {
        if (Auth::user()->id !== $task->user_id) {
            return false;
        }
        return true;
    }

    private function notAuthorizedResponse(): JsonResponse
    {
        return $this->error([], 'You are not authorized to make this request', 403);
    }
}
