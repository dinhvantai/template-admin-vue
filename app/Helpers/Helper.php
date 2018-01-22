<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

class Helper
{
    static function formatPaginate(LengthAwarePaginator $paginage)
    {
        return [
            'current_page' => $paginage->currentPage(),
            'data' => $paginage->items(),
            'total' => $paginage->total(),
        ];
    }
}
