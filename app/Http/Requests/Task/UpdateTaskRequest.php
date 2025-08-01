<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => "sometimes|string|max:255",
            "description" => "sometimes|nullable|string",
            "completed" => "sometimes|boolean",
            "due_date" => "sometimes|nullable|date",
            "priority" => "sometimes|nullable|integer|min:1|max:5",
            "categories" => "sometimes|array|nullable",
            "categories.*" => [
                "integer",
                Rule::exists("categories", "id")->where("user_id", Auth::id())
            ]
        ];
    }
}
