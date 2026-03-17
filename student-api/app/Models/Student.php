<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nim', 'name', 'email', 'phone', 'gender',
        'birth_date', 'address', 'major_id',
        'status', 'semester', 'gpa',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'gpa'        => 'float',
        'semester'   => 'integer',
    ];

    // ── Relationships ──
    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    // ── Scopes ──
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (!$keyword) return $query;

        return $query->where(function ($q) use ($keyword) {
            $q->where('name',  'like', "%{$keyword}%")
              ->orWhere('nim',   'like', "%{$keyword}%")
              ->orWhere('email', 'like', "%{$keyword}%");
        });
    }

    public function scopeFilterStatus(Builder $query, ?string $status): Builder
    {
        return $status ? $query->where('status', $status) : $query;
    }

    public function scopeFilterMajor(Builder $query, ?int $majorId): Builder
    {
        return $majorId ? $query->where('major_id', $majorId) : $query;
    }

    public function scopeFilterGender(Builder $query, ?string $gender): Builder
    {
        return $gender ? $query->where('gender', $gender) : $query;
    }
}
