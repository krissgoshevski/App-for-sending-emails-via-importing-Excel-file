<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Import;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImportExcelFilesController extends Controller {


public function importExcel(Request $request)
    {
        $request->validate([
            'excelFile' => 'required|mimes:xlsx,xls',
        ]);

        if ($request->hasFile('excelFile')) {
            $file = $request->file('excelFile');

            if ($file->isValid() && in_array($file->getClientOriginalExtension(), ['xlsx', 'xls'])) {
                $filename = 'excel_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('excel', $filename);
                Excel::import(new Import(), $file);
                
                return redirect()->route('index.page')->with('status', 'All details of excel file imported succesfully');
            }
        }

        return redirect()->back()->with('error', 'Invalid Excel file');
    }

  

public function index()
{
    $filePath = storage_path('app/excel');

    if (file_exists($filePath)) {
        $importedData = [];

        $files = File::files($filePath);

        foreach ($files as $file) {
            $data = Excel::toArray(new Import(), $file);

            if (!empty($data[0])) {
                foreach ($data[0] as $row) {
                    // Check if the row contains any non-empty value
                    if ($this->hasNonEmptyValue($row)) {
                        $importedData[] = $row;
                    }
                }
            }
        }

        return view('index', ['rows' => $importedData]);
    } else {
        // If the directory doesn't exist, return an empty array
        return view('index', ['rows' => []])->with('error', 'File not found');
    }
}

private function hasNonEmptyValue($row)
{
    foreach ($row as $value) {
        // Check if the value is not null and not empty after trimming whitespace
        if (!is_null($value) && trim($value) !== '') {
            return true; // Found a non-empty value, return true
        }
    }
    return false; // No non-empty value found in the row
}




    public function deleteExcelFile()
    {
        $filePath = storage_path('app/excel');
        
        if (file_exists($filePath)) {
            File::deleteDirectory($filePath);
            return redirect()->route('index.page')->with('status', 'Excel table deleted successfully');
        } else {
            return redirect()->route('index.page')->with('error', 'Excel file not found');
        }
    }


}