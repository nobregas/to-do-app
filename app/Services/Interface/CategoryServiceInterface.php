<?php

namespace App\Services\Interface;


use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface CategoryServiceInterface
{
    public function findAll(): AnonymousResourceCollection;

    public function find($id): ?CategoryResource;

    public function create(StoreCategoryRequest $input):  CategoryResource;

    public function update($id, UpdateCategoryRequest $input): CategoryResource;

    public function delete($id): void;
}
