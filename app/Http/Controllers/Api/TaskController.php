<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskController extends Controller
{

    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        $tasks = $this->taskRepository->all();

        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskRepository->create($request->validated());

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $task = $this->taskRepository->find($id);

        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        $task = $this->taskRepository->update($id, $request->validated());

        return new TaskResource($task);
    }

    public function destroy($id)
    {
        $this->taskRepository->delete($id);

        return response()->json(null, 204);
    }
}
