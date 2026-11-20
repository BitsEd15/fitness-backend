<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreExerciseRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string'],
            'full_description' => ['required', 'string'],
            'video_url' => ['nullable','string'],
            // Ожидаем массив ID и проверяем их существование в связанных таблицах
            'training_type_ids' => ['required', 'array'],
            'training_type_ids.*' => ['exists:training_types,id'],
            'muscle_group_ids' => ['required', 'array'],
            'muscle_group_ids.*' => ['exists:muscle_groups,id'],
        ];
    }
}
