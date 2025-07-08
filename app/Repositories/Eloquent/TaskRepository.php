<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\exceptions\ResourceNotFoundException;
use App\Exceptions\exceptions\TaskAlreadyCompletedException;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class TaskRepository implements TaskRepositoryInterface
{
    public function all(): Collection
    {
        return Auth::user()->tasks()->with("categories")->get();
    }

    public function create(array $data): Model
    {
        $task = Auth::user()->tasks()->create($data);

        if (isset($data['categories'])) {
            $task->categories()->sync($data['categories']);
        }

        $task->load("categories");
        return $task;
    }

    public function find(int $id): ?Model
    {
        $task = Auth::user()->tasks()->with('categories')->find($id);

        if (!$task) {
            throw new ResourceNotFoundException();
        }

        return $task;
    }

    public function update(int $id, array $data): Model
    {
        $task = $this->find($id);

        if ($task->completed) {
            throw new TaskAlreadyCompletedException();
        }

        $task->update($data);

        if (isset($data['categories'])) {
            $task->categories()->sync($data['categories']);
        }

        $task->load('categories');
        return $task;
    }

    public function delete(int $id): bool
    {
        $task = $this->find($id);

        return $task->delete();
    }
}
