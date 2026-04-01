<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'nim'        => $this->nim,
            'name'       => $this->name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'gender'     => $this->gender,
            'birth_date' => $this->birth_date?->format('Y-m-d'),
            'address'    => $this->address,
            'status'     => $this->status,
            'semester'   => $this->semester,
            'gpa'        => number_format($this->gpa, 2),
            'major'      => $this->whenLoaded('major', fn() => [
                'id'      => $this->major->id,
                'code'    => $this->major->code,
                'name'    => $this->major->name,
                'faculty' => $this->major->faculty,
            ]),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'deleted_at' => $this->when($this->deleted_at, $this->deleted_at?->toISOString()),
        ];
    }
}
