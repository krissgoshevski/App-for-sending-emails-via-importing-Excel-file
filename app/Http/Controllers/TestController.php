<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Import;


class TestController extends Controller
{


public function generateRandomEmailsArray() {

    $randomStrings = [
        'john.doe@example.com',
        'jane.doe@example.com',
        'alice@example.com',
        'bob@example.com',
        'bob@example.com' 
    ];

    // Step 2: Shuffle the array to randomize the order
    shuffle($randomStrings);

    // Step 3: Join the strings with semicolons and commas
    $randomEmailsString = implode(';', $randomStrings);

    // dd($randomEmailsString);

    // Step 4: Explode the string to get an array of email addresses
    $emails = explode(';', $randomEmailsString);

   // dd($emails);

    // Step 5: Trim whitespace from each email address
    $emails = array_map(function($email) {
        return trim($email);
    }, $emails);


       // + ASC have array_filter 
    $emails = array_filter(array_map('trim', $emails)); // two in one 

   // dd($emails);

    // Step 6: Remove any empty email addresses
    $emails = array_filter($emails);

    // Step 7: Remove duplicate email addresses
    $emails = array_unique($emails);

   // dd($emails);

    // Step 8: Return the resulting array
    return $emails;
}

public function showListsOfExcelFile()
{
    $filePath = storage_path('app/public/new_izvestuvanje.xlsx');

    if (file_exists($filePath)) {
        $data = Excel::toArray(new Import(), $filePath);

        // Provjerite je li $data prazan ili nedefiniran
        if (!empty($data) && isset($data[0])) {
            // broj na zapisi na redici od excel file
            $rowCount = count($data[0]);

            // Broj na koloni od listot of prv red
            $columnCount = count($data[0][0]); // elementi vo prv red 

            dd("Prviot list sodrzi $rowCount redovi i $columnCount koloni");
        } else {
            dd("Excel datotekata e prazna ili ne sodrzi nisto");
        }
    } else {
        dd("Excel file not found");
    }
}




    
}
