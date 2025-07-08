<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 * schema="CategoryResource",
 * type="object",
 * title="Recurso de Categoria",
 * @OA\Property(property="id", type="integer", description="ID da categoria", example=1),
 * @OA\Property(property="name", type="string", description="Nome da categoria", example="Pessoal"),
 * @OA\Property(property="color", type="string", format="hex", description="Cor da categoria em formato hexadecimal", example="#D0021B")
 * )
 */
class CategoryResource extends JsonResource
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
            "name" => $this->name,
            "color" => $this->color,
        ];
    }
}
