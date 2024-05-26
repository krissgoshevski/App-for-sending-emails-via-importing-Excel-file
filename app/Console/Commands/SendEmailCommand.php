<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Imports\Import;
use Maatwebsite\Excel\Facades\Excel;

class SendEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email with data from Excel file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    // public function handle()
    // {
    //     $filePath = storage_path('app/public/izvestuvanje.xlsx');

    //     if (file_exists($filePath)) {
    //         $data = Excel::toArray(new Import(), $filePath);

    //         if (!empty($data)) {
    //             $rows = $data[0];

    //             Mail::to([
    //                 'kristijan.gosevski@neotel.mk',
    //             ])
    //             ->cc('riste.tashkoski@neotel.mk')
    //             ->send(new SendEmail($rows));

    //             $this->info('Email sent successfully');
    //         } else {
    //             $this->error('No data found');
    //         }
    //     } else {
    //         $this->error('File not found');
    //     }
    // }
}
