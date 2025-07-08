<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    public function all(): Collection;

    public function create(array $data): Model;

    public function find(int $id): ?Model;

    public function update(int $id, array $data): Model;

    public function delete(int $id): bool;
}
