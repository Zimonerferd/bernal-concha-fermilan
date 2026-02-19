<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employees extends Model
{
    use SoftDeletes;

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

    protected $dates = [
        'DateOfBirth',
        'deleted_at',
    ];
}