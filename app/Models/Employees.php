<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employees extends Model
{
    use SoftDeletes;

    protected $table = 'employees';

    protected $fillable = [
        'FirstName',
        'LastName',
        'MiddleName',
        'NameExtension',
        'DateOfBirth',
        'CivilStatus',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'DateOfBirth' => 'date',
    ];

    public function getFullNameAttribute(): string
    {
        $middle = $this->MiddleName ? ' ' . $this->MiddleName[0] . '.' : '';
        $ext    = $this->NameExtension ? ' ' . $this->NameExtension : '';
        return "{$this->LastName}, {$this->FirstName}{$middle}{$ext}";
    }
}