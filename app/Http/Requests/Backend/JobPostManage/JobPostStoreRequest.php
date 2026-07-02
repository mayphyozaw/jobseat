<?php

namespace App\Http\Requests\Backend\JobPostManage;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobPostStoreRequest extends FormRequest
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
            'country_id' => 'required|integer|exists:countries,id',
            'company_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',

            'male_count' => 'required|integer|min:0',
            'female_count' => 'required|integer|min:0',
            'total_count' => 'required|integer|min:0',

            'age_limit' => 'required|string|max:255',

            'salary' => 'required|string|max:255',
            'deposit_fee' => 'required|numeric|min:0',

            'description' => 'required|string',
            'deadline' => 'required|date',

            // 'status' => 'required|string|max:255',

            'job_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }
}
