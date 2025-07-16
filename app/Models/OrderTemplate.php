<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTemplate extends Model
{
protected $fillable = [
    'project_title', 'request_type', 'sub_service', 'instructions',
    'colors', 'size', 'other_size', 'software', 'other_software',
    'brands_profile_id', 'formats', 'pre_approve', 'rush', 'created_by',
];

protected $casts = [
    'formats' => 'array',
    'rush' => 'boolean',
];
}
