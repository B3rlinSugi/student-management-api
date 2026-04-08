<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'nim'        => $this->nim,
            'name'       => $this->name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'gender'     => $this->gender,
            'birth_date' => $this->birth_date ? $this->birth_date->format('Y-m-d') : null,
            'address'    => $this->address,
            'status'     => $this->status,
            'semester'   => $this->semester,
            'gpa'        => number_format($this->gpa, 2),
            'major'      => $this->whenLoaded('major', function () {
                return [
                    'id'      => $this->major->id,
                    'code'    => $this->major->code,
                    'name'    => $this->major->name,
                    'faculty' => $this->major->faculty,
                ];
            }),
            'created_at' => $this->created_at ? $this->created_at->toISOString() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toISOString() : null,
        ];
    }
}