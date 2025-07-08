<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 * schema="LoginSuccessResource",
 * type="object",
 * title="Resposta de Login/Registro Bem-Sucedido",
 * @OA\Property(property="access_token", type="string", description="Token de acesso Bearer"),
 * @OA\Property(property="token_type", type="string", example="Bearer"),
 * @OA\Property(property="user", ref="#/components/schemas/UserResource")
 * )
 */
class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => "required|email",
            "password" => "required",
        ];
    }
}
