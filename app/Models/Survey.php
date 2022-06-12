<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'comments',
        'service_qualification',
        'filing_qualification',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
