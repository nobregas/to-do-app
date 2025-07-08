<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\Interface\CategoryServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryServiceInterface $categoryService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return $this->categoryService->findAll();
    }

    public function show(int $id):  CategoryResource
    {
        return $this->categoryService->find($id);
    }

    public function store(StoreCategoryRequest $request):  JsonResponse
    {
        $category = $this->categoryService->create($request);

        return ($category)
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateCategoryRequest $request,int $id): CategoryResource
    {
        return $this->categoryService->update($id, $request);
    }

    public function delete(int $id): JsonResponse
    {
        $this->categoryService->delete($id);

        return response()->json(null, 204);
    }
}
