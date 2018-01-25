<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const STATUS_SHOW = 'show';
    const STATUS_HIDDEN = 'hidden';
}
