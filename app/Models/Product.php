<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const STATUS_SHOW = 'show';
    const STATUS_HIDDEN = 'hidden';

    protected $fillable = [
        'name',
        'slug',
        'price',
        'unit',
        'detail',
        'guide',
        'guarantee',
        'total_views',
        'status',
        'prioty',
        'category_id',
        'seo_keyword',
        'seo_description',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
