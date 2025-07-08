<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\Interface\CategoryServiceInterface;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryServiceInterface $categoryService)
    {
    }

    public function index()
    {
        return $this->categoryService->findAll();
    }

    public function show($id)
    {
        return $this->categoryService->find($id);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->create($request);

        return ($category)
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        return $this->categoryService->update($id, $request);
    }

    public function delete($id)
    {
        $this->categoryService->delete($id);

        return response()->json(null, 204);
    }
}
