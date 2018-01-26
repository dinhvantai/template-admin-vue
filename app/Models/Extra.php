<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    protected $fillable = [
        'position',
        'seo_keyword',
        'seo_description',
    ];
}
