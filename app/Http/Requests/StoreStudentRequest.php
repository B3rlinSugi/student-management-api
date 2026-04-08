<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nim'        => 'required|string|max:20|unique:students,nim',
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|unique:students,email',
            'phone'      => 'nullable|string|max:20',
            'gender'     => 'required|in:male,female',
            'birth_date' => 'nullable|date|before:today',
            'address'    => 'nullable|string',
            'major_id'   => 'required|exists:majors,id',
            'status'     => 'sometimes|in:active,inactive,graduated,dropout',
            'semester'   => 'sometimes|integer|min:1|max:14',
            'gpa'        => 'sometimes|numeric|min:0|max:4',
        ];
    }
}
