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
        'image',
        'description',
        'detail',
        'guide',
        'guarantee',
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
