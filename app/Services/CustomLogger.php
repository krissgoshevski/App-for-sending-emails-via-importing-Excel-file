<?php

namespace App\Services;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CustomLogger
{
    // File name for the log
    protected $fileName;

    // Constructor to set the log file name
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    // Method to create log
    public function createLog($message)
    {
        // Create a new Monolog logger instance with the specified file name
        $log = new Logger($this->fileName);

        // Push a new stream handler to write logs to the specified log file
        $log->pushHandler(new StreamHandler(storage_path("logs/mylogs/{$this->fileName}.log"), Logger::INFO));

        // Add a log record with the INFO level
        $log->info($message);
    }
}
