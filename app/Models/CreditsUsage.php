<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditsUsage extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_id',
        'credits_used',
        'description',
        'status',
        'job_id',
        'rush',
    ];
}
