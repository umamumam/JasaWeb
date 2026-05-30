<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'github_id',
        'name',
        'title',
        'client',
        'category',
        'description',
        'github_url',
        'demo_url',
        'image_path',
        'tech',
        'impact',
        'wa_message',
        'is_visible',
        'order_index',
    ];

    protected $casts = [
        'tech' => 'array',
        'is_visible' => 'boolean',
        'order_index' => 'integer',
    ];
}
