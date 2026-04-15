<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'slug', 'name', 'icon', 'color', 'bg',
        'cases_count', 'collected', 'target',
    ];

    public function cases()
    {
        return $this->hasMany(HelpCase::class);
    }
}
