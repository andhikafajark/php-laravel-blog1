<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'datatable' => 'bail|nullable|boolean',
            'limit' => 'bail|nullable|integer|gte:1',
            'offset' => 'bail|nullable|integer|gte:1',
            'order_column' => 'bail|nullable|string',
            'order_direction' => 'bail|nullable|string|in:asc,desc',
            'search' => 'bail|nullable|string',
            'relations' => 'bail|nullable|string'
        ];
    }
}
