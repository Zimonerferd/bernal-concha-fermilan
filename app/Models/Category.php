<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'color',
        'icon',
    ];

    public function polls()
    {
        return $this->hasMany(Poll::class);
    }
}