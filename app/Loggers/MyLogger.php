<?php

namespace App\Loggers;

use Illuminate\Support\Facades\Log;

class MyLogger
{
    public static function myLog($message, $level = 'info', $context = [])
    {
        Log::$level($message, $context);
        // You can add your own custom logic here if needed
    }
}


