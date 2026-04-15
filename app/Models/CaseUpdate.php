<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseUpdate extends Model
{
    protected $fillable = [
        'case_id', 'title', 'details',
        'added_by', 'donation_amount', 'emoji',
    ];

    public function case()
    {
        return $this->belongsTo(HelpCase::class, 'case_id');
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
