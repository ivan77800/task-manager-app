<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Task;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:' . implode(',', Task::getStatuses()),
            'priority' => 'required|in:' . implode(',', Task::getPriorities())
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The task title is required',
            'title.max' => 'The task title cannot exceed 255 characters',
            'status.required' => 'Please select a status',
            'status.in' => 'Invalid status value',
            'priority.required' => 'Please select a priority',
            'priority.in' => 'Invalid priority value'
        ];
    }
}
