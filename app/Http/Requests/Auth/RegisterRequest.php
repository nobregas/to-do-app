<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 * schema="UserResource",
 * type="object",
 * title="Recurso de Usuário",
 * @OA\Property(property="id", type="string", format="uuid", description="ID do usuário"),
 * @OA\Property(property="name", type="string", description="Nome do usuário"),
 * @OA\Property(property="email", type="string", format="email", description="Email do usuário")
 * )
 */
class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
