<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
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
            "title" => "required|string|max:255",
            "description" => "nullable|string",
            "due_date" => "nullable|date", //AAAA-MM-DD
            "priority" => "nullable|integer|max:5",
            "categories" => "nullable|array",
            "categories.*" => [
                "integer",
                Rule::exists("categories", "id")->where("user_id", Auth::id())
            ]
        ];
    }
}
