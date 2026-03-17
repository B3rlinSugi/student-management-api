<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $studentId = $this->route('student')?->id;

        return [
            'nim'        => "sometimes|string|max:20|unique:students,nim,{$studentId}",
            'name'       => 'sometimes|string|max:100',
            'email'      => "sometimes|email|unique:students,email,{$studentId}",
            'phone'      => 'nullable|string|max:20',
            'gender'     => 'sometimes|in:male,female',
            'birth_date' => 'nullable|date|before:today',
            'address'    => 'nullable|string',
            'major_id'   => 'sometimes|exists:majors,id',
            'status'     => 'sometimes|in:active,inactive,graduated,dropout',
            'semester'   => 'sometimes|integer|min:1|max:14',
            'gpa'        => 'sometimes|numeric|min:0|max:4',
        ];
    }
}
