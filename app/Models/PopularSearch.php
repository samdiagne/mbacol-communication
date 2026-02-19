<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopularSearch extends Model
{
    protected $fillable = [
        'query',
        'search_count',
        'click_count',
        'last_searched_at',
    ];

    protected $casts = [
        'last_searched_at' => 'datetime',
    ];
}