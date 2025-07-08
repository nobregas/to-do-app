<?php

namespace App\Services\Interface;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface TaskServiceInterface
{
    public function findAll(): AnonymousResourceCollection;

    public function find($id): ?TaskResource;

    public function create(StoreTaskRequest $input):  TaskResource;

    public function update($id, UpdateTaskRequest $input): TaskResource;

    public function delete($id): void;
}
