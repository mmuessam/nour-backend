<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpCase extends Model
{
    protected $table = 'cases';

    protected $fillable = [
        'case_number', 'title', 'category_id', 'description',
        'beneficiary', 'target', 'collected', 'status',
        'priority', 'location', 'image', 'created_by',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'case_id');
    }

    public function updates()
    {
        return $this->hasMany(CaseUpdate::class, 'case_id');
    }
}
