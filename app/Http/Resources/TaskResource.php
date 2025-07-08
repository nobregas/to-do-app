<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @OA\Schema(
 * schema="TaskResource",
 * type="object",
 * title="Recurso de Tarefa",
 * @OA\Property(property="id", type="integer", description="ID da tarefa", example=1),
 * @OA\Property(property="title", type="string", description="Título da tarefa", example="Minha Primeira Tarefa"),
 * @OA\Property(property="description", type="string", nullable=true, description="Descrição detalhada da tarefa", example="Fazer algo importante."),
 * @OA\Property(property="completed", type="boolean", description="Indica se a tarefa foi concluída", example=false),
 * @OA\Property(property="due_date", type="string", format="date", nullable=true, description="Data de vencimento", example="2025-12-31"),
 * @OA\Property(property="priority", type="integer", nullable=true, description="Nível de prioridade (1-5)", example=4),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Data de criação"),
 * @OA\Property(property="categories", type="array", @OA\Items(ref="#/components/schemas/CategoryResource"))
 * )
 */
class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "completed" => $this->completed,
            "due_date" => $this->due_date,
            "priority" => $this->priority,
            "created_at" => $this->created_at->toDateTimeString(),
            "categories" => $this->CategoryResource::collection($this->whenLoaded('categories')),
        ];
    }
}
