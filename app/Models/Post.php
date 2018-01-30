<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const STATUS_SHOW = 'show';
    const STATUS_HIDDEN = 'hidden';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'detail',
        'status',
        'prioty',
        'category_id',
        'seo_keyword',
        'seo_description',
    ];
}
