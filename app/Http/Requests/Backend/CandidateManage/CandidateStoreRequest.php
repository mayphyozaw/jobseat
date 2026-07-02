<?php

namespace App\Http\Requests\Backend\CandidateManage;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CandidateStoreRequest extends FormRequest
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
            
            'full_name'       => 'required|string|max:255',
            'phone'           => 'required|string|max:20|unique:candidates',
            'nrc_number'      => 'nullable|string|max:50|unique:candidates',
            'passport_number' => 'nullable|string|max:50|unique:candidates',
            'date_of_birth'   => 'nullable|date',
            'age'             => 'nullable|string',
            'gender'          => 'nullable|in:male,female,other',
            'address'         => 'nullable|string',
            'notes'           => 'nullable|string',
            'nrc_front_path'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'nrc_back_path'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'passport_path'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'photo_path'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'job_post_id'    => 'nullable|exists:job_posts,id',
           
        ];
    }
}
