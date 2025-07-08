<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TaskResource;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    public function index()
    {
        $categories = $this->categoryRepository->all();

        return CategoryResource::collection($categories);
    }

    public function show($id)
    {
        $category = $this->categoryRepository->find($id);

        return new CategoryResource($category);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryRepository->create($request->validated());

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category =  $this->categoryRepository->update($id, $request->validated());

        return new CategoryResource($category);
    }

    public function delete($id)
    {
        $this->categoryRepository->delete($id);

        return response()->json(null, 204);
    }
}
