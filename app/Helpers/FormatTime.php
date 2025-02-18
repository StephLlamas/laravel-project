<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FormatTime
{
    public static function LongTimeFilter($date) {
        if($date == null){
            return 'Sin fecha';
        }
        
        return Carbon::createFromTimeStamp(strtotime($image->created_at))->locale('es')->diffForHumans();
    }
}

?>