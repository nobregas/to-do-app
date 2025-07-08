<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\Interface\TaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{

    private TaskServiceInterface $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(): AnonymousResourceCollection
    {
        return $this->taskService->findAll();
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->create($request);

        return ($task)
            ->response()
            ->setStatusCode(201);
    }

    public function show(int $id): TaskResource
    {
        return $this->taskService->find($id);
    }

    public function update(UpdateTaskRequest $request, int $id): TaskResource
    {
        return $this->taskService->update($id, $request);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->taskService->delete($id);

        return response()->json(null, 204);
    }
}
