<?php

namespace App\Services\Impl;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Services\Interface\CategoryServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        Log::info('Category created successfully.', [
            'category_id' => $category->id,
            'user_id' => Auth::id(),
            'category_name' => $category->name,
        ]);

        return new CategoryResource($category);
    }

    public function update($id, UpdateCategoryRequest $input): CategoryResource
    {
        $category =  $this->categoryRepository->update($id, $input->validated());

        Log::info('Category updated successfully.', [
            'category_id' => $category->id,
            'user_id' => Auth::id(),
        ]);

        return new CategoryResource($category);
    }

    public function delete($id): void
    {
        Log::info('Attempting to delete category.', [
            'category_id' => $id,
            'user_id' => Auth::id(),
        ]);

        $this->categoryRepository->delete($id);
    }

    
}
