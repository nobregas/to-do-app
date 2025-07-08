<?php

namespace App\Services\Impl;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Services\Interface\CategoryServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

readonly class CategoryService implements CategoryServiceInterface
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function findAll(): AnonymousResourceCollection
    {
        $categories = $this->categoryRepository->all();

        return CategoryResource::collection($categories);
    }

    public function find($id): ?CategoryResource
    {
        $category = $this->categoryRepository->find($id);

        return new CategoryResource($category);
    }

    public function create(StoreCategoryRequest $input): CategoryResource
    {
        $category = $this->categoryRepository->create($input->validated());

        return new CategoryResource($category);
    }

    public function update($id, UpdateCategoryRequest $input): CategoryResource
    {
        $category =  $this->categoryRepository->update($id, $input->validated());
        return new CategoryResource($category);
    }

    public function delete($id): void
    {
        $this->categoryRepository->delete($id);
    }
}
