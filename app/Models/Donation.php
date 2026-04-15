<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'donation_number', 'case_id', 'amount', 'source',
        'source_name', 'method', 'date', 'added_by', 'notes',
    ];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function case()
    {
        return $this->belongsTo(HelpCase::class, 'case_id');
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
