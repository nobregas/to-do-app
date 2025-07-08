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

    /**
     * @OA\Get(
     * path="/api/categories",
     * operationId="getCategoryList",
     * tags={"Categorias"},
     * summary="Lista todas as categorias do usuário",
     * description="Retorna uma lista paginada de categorias pertencentes ao usuário autenticado.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Operação bem-sucedida",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref="#/components/schemas/CategoryResource")
     * )
     * ),
     * @OA\Response(response=401, description="Não autorizado")
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        return $this->categoryService->findAll();
    }

    /**
     * @OA\Get(
     * path="/api/categories/{id}",
     * operationId="getCategoryById",
     * tags={"Categorias"},
     * summary="Obtém informações de uma categoria",
     * description="Retorna os dados de uma categoria específica.",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * description="ID da Categoria",
     * required=true,
     * in="path",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Operação bem-sucedida",
     * @OA\JsonContent(ref="#/components/schemas/CategoryResource")
     * ),
     * @OA\Response(response=401, description="Não autorizado"),
     * @OA\Response(response=404, description="Recurso não encontrado")
     * )
     */
    public function show(int $id):  CategoryResource
    {
        return $this->categoryService->find($id);
    }

    /**
     * @OA\Post(
     * path="/api/categories",
     * operationId="storeCategory",
     * tags={"Categorias"},
     * summary="Cria uma nova categoria",
     * description="Cria uma nova categoria e retorna seus dados.",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * description="Dados da nova categoria",
     * @OA\JsonContent(
     * required={"name"},
     * @OA\Property(property="name", type="string", example="Trabalho"),
     * @OA\Property(property="color", type="string", format="hex", example="#4A90E2")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Categoria criada com sucesso",
     * @OA\JsonContent(ref="#/components/schemas/CategoryResource")
     * ),
     * @OA\Response(response=401, description="Não autorizado"),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreCategoryRequest $request):  JsonResponse
    {
        $category = $this->categoryService->create($request);

        return ($category)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * @OA\Patch(
     * path="/api/categories/{id}",
     * operationId="updateCategory",
     * tags={"Categorias"},
     * summary="Atualiza uma categoria existente",
     * description="Atualiza os dados de uma categoria existente.",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * description="ID da Categoria",
     * required=true,
     * in="path",
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * description="Novos dados da categoria",
     * @OA\JsonContent(
     * required={"name"},
     * @OA\Property(property="name", type="string", example="Estudos"),
     * @OA\Property(property="color", type="string", format="hex", example="#F5A623")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Categoria atualizada com sucesso",
     * @OA\JsonContent(ref="#/components/schemas/CategoryResource")
     * ),
     * @OA\Response(response=401, description="Não autorizado"),
     * @OA\Response(response=404, description="Recurso não encontrado"),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function update(UpdateCategoryRequest $request,int $id): CategoryResource
    {
        return $this->categoryService->update($id, $request);
    }

    /**
     * @OA\Delete(
     * path="/api/categories/{id}",
     * operationId="deleteCategory",
     * tags={"Categorias"},
     * summary="Exclui uma categoria",
     * description="Exclui uma categoria existente.",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * description="ID da Categoria",
     * required=true,
     * in="path",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=204,
     * description="Categoria excluída com sucesso"
     * ),
     * @OA\Response(response=401, description="Não autorizado"),
     * @OA\Response(response=404, description="Recurso não encontrado")
     * )
     */
    public function delete(int $id): JsonResponse
    {
        $this->categoryService->delete($id);

        return response()->json(null, 204);
    }
}
