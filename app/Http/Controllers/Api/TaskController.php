<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Services\Interface\TaskServiceInterface;

class TaskController extends Controller
{

    private TaskServiceInterface $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        return $this->taskService->findAll();
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->create($request);

        return ($task)
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        return $this->taskService->find($id);
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        return $this->taskService->update($id, $request);
    }

    public function destroy($id)
    {
        $this->taskService->delete($id);

        return response()->json(null, 204);
    }
}
