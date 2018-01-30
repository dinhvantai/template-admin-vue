<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    const POSITION_SLIDER = 'banner';

    const STATUS_SHOW = 'show';
    const STATUS_HIDDEN = 'hidden';

    protected $fillable = [
        'name',
        'position',
        'status',
        'seo_keyword',
        'seo_description',
    ];
}
