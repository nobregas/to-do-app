<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\Interface\TaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{

    private TaskServiceInterface $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @OA\Get(
     * path="/api/tasks",
     * operationId="getTaskList",
     * tags={"Tarefas"},
     * summary="Lista todas as tarefas do usuário",
     * description="Retorna uma lista de tarefas pertencentes ao usuário autenticado.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Operação bem-sucedida",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref="#/components/schemas/TaskResource")
     * )
     * ),
     * @OA\Response(response=401, description="Não autorizado")
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        return $this->taskService->findAll();
    }

    /**
     * @OA\Post(
     * path="/api/tasks",
     * operationId="storeTask",
     * tags={"Tarefas"},
     * summary="Cria uma nova tarefa",
     * description="Cria uma nova tarefa e a associa a categorias, se fornecido.",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * description="Dados da nova tarefa",
     * @OA\JsonContent(
     * required={"title"},
     * @OA\Property(property="title", type="string", example="Desenvolver nova feature"),
     * @OA\Property(property="description", type="string", example="Detalhes da implementação da feature X."),
     * @OA\Property(property="due_date", type="string", format="date", example="2025-12-31"),
     * @OA\Property(property="priority", type="integer", example=3),
     * @OA\Property(property="categories", type="array", @OA\Items(type="integer"), example={1, 2})
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Tarefa criada com sucesso",
     * @OA\JsonContent(ref="#/components/schemas/TaskResource")
     * ),
     * @OA\Response(response=401, description="Não autorizado"),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->create($request);

        return ($task)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * @OA\Get(
     * path="/api/tasks/{id}",
     * operationId="getTaskById",
     * tags={"Tarefas"},
     * summary="Obtém informações de uma tarefa",
     * description="Retorna os dados de uma tarefa específica.",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * description="ID da Tarefa",
     * required=true,
     * in="path",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Operação bem-sucedida",
     * @OA\JsonContent(ref="#/components/schemas/TaskResource")
     * ),
     * @OA\Response(response=401, description="Não autorizado"),
     * @OA\Response(response=404, description="Recurso não encontrado")
     * )
     */
    public function show(int $id): TaskResource
    {
        return $this->taskService->find($id);
    }

    /**
     * @OA\Patch(
     * path="/api/tasks/{id}",
     * operationId="updateTask",
     * tags={"Tarefas"},
     * summary="Atualiza uma tarefa existente (parcial)",
     * description="Atualiza os dados de uma tarefa existente. Apenas os campos fornecidos serão atualizados.",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * description="ID da Tarefa",
     * required=true,
     * in="path",
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * description="Novos dados da tarefa",
     * @OA\JsonContent(
     * @OA\Property(property="title", type="string", example="Revisar documentação"),
     * @OA\Property(property="completed", type="boolean", example=true),
     * @OA\Property(property="priority", type="integer", example=5),
     * @OA\Property(property="categories", type="array", @OA\Items(type="integer"), example={3})
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Tarefa atualizada com sucesso",
     * @OA\JsonContent(ref="#/components/schemas/TaskResource")
     * ),
     * @OA\Response(response=401, description="Não autorizado"),
     * @OA\Response(response=404, description="Recurso não encontrado"),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function update(UpdateTaskRequest $request, int $id): TaskResource
    {
        return $this->taskService->update($id, $request);
    }

    /**
     * @OA\Delete(
     * path="/api/tasks/{id}",
     * operationId="deleteTask",
     * tags={"Tarefas"},
     * summary="Exclui uma tarefa",
     * description="Exclui uma tarefa existente.",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * description="ID da Tarefa",
     * required=true,
     * in="path",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=204,
     * description="Tarefa excluída com sucesso"
     * ),
     * @OA\Response(response=401, description="Não autorizado"),
     * @OA\Response(response=404, description="Recurso não encontrado")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->taskService->delete($id);

        return response()->json(null, 204);
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        return null;
    }
}
