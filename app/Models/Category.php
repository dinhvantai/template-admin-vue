<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const TYPE_PRODUCT = 'product';
    const TYPE_POST = 'post';

    const STATUS_SHOW = 'show';
    const STATUS_HIDDEN = 'hiden';
}
