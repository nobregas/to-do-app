<?php

namespace App\Services\Impl;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Services\Interface\TaskServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

readonly class TaskService implements TaskServiceInterface
{

    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function findAll(): AnonymousResourceCollection
    {
        $tasks = $this->taskRepository->all();

        return TaskResource::collection($tasks);
    }

    public function find($id): ?TaskResource
    {
        $task = $this->taskRepository->find($id);

        return new TaskResource($task);
    }

    public function create(StoreTaskRequest $input): TaskResource
    {
        $task = $this->taskRepository->create($input->validated());

        return new TaskResource($task);
    }

    public function update($id, UpdateTaskRequest $input): TaskResource
    {
        $task = $this->taskRepository->update($id, $input->validated());

        return new TaskResource($task);
    }

    public function delete($id): void
    {
        $this->taskRepository->delete($id);
    }
}
