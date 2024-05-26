<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelImportExportController;
use App\Http\Controllers\ImportExcelFilesController;
use App\Services\CustomLogger;
use Illuminate\Support\Str;


Route::redirect('/', '/planirana_rabota'); // Redirect default route to /planirana_rabota

Route::get('/planirana_rabota', function (){
    return view('import');
})->name('import.excel.get');



Route::post('/planirana_rabota', [ImportExcelFilesController::class,'importExcel'])->name('import-excel'); // import-excel
Route::get('/view/table', [ImportExcelFilesController::class, 'index'])->name('index.page');



Route::get('/emails/preview', [ExcelImportExportController::class,'previewEmails'])->name('preview.emails');
Route::post('/emails/send', [ExcelImportExportController::class,'sendMultipleEmails'])->name('send-multiple-emails'); // send-multiple-emails


Route::delete('/delete-excel', [ImportExcelFilesController::class, 'deleteExcelFile'])->name('delete.excel');


// Route::post('/emails/store', [ExcelImportExportController::class,'storeEmails'])->name('store.emails');


Route::post('/store', [ExcelImportExportController::class,'store'])->name('post.store');


Route::get('/store', function(){
    return view('store');
})->name('get.store');


// GRANT ALL PRIVILEGES ON planirana_rabota.* TO 'planirana'@'localhost';
// CREATE USER 'planirana'@'localhost' IDENTIFIED BY 'your_password';





Route::get('/generatePassword', function(){
   
    $length = 13; 
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';

     $password = Str::random($length, $characters);

    return $password;
});



Route::get('/proverka', [ExcelImportExportController::class,'proverkaZaMeil']);



Route::get('/ceil', function(){

   // $timeout = ceil(30 / 3); // konvertira vo cel broj, 30 / 3 ako imam 3 mx records 
   // $timeout = ceil(127 / 3); // konvertira vo cel broj, 43 vraka cel broj 

    $timeout = (int)(127 / 3); // konvertira vo cel broj, 43 vraka cel broj , znaci bez decimalni mesta 


    echo $timeout; // vraka 10 


});

Route::get('/ceil/intval', function(){
    $timeout = ceil(127 / 3); // Perform ceil operation
    $timeout = intval($timeout); // Convert to integer using intval()
    echo $timeout; // Output: 43
});


Route::get('/ceil/int', function(){
    $timeout = ceil(127 / 3); // Perform ceil operation
    $timeout = (int)$timeout; // Convert to integer using typecasting
    echo $timeout; // Output: 43
});










Route::get('/tt', function()
{
 
// Example of creating a logger instance and logging a message
$logger = new CustomLogger('MyLoggs');
$logger->createLog('This is a log message.');

});



