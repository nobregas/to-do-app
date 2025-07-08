<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\exceptions\ResourceNotFoundException;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CategoryRepository implements CategoryRepositoryInterface
{

    public function all(): Collection
    {
        return Auth::user()->categories;
    }

    public function find(int $id): ?Model
    {
        $category = Auth::user()->categories()->find($id);

        if (!$category) {
            throw new ResourceNotFoundException();
        }

        return $category;
    }

    public function create(array $data):Model
    {
        $category = Auth::user()->categories()->create($data);
        if ($category->color == null) {
            $category->color = "#ffffff";
        }
        return $category;
    }

    public function update(int $id, array $data): Model
    {
        $category = $this->find($id);

        return $category->update($data);
    }

    public function delete(int $id): bool
    {
        $category = $this->find($id);
        return $category->delete();
    }
}
