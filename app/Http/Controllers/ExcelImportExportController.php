<?php namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Import;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use App\Mail\SendEmail as SendMailableClass;
use App\Models\SentEmailModel;
use illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

  
class ExcelImportExportController extends Controller
{

// preview of the emails how will looks
public function previewEmails()
{
    $directoryPath = storage_path('app/excel');
    $excelData = $this->getExcelDataFromDirectory($directoryPath);


    if (!empty($excelData)) {
        $previewEmails = [];

        foreach ($excelData as $rows) {
                    $skipFirstRow = true; // Flag to skip the first row

            foreach ($rows as $row) {

                    // Skip the first row
                if ($skipFirstRow) {
                    $skipFirstRow = false;
                    continue;
                }

                if (isset($row[6]) && isset($row[7])) {
                    $emails = explode(';', $row[0]);
                    $emails = array_filter(array_map('trim', $emails));
                    $emails = array_unique($emails);

                    if (!empty($emails)) {
                        $language = strtolower(trim($row[6]));
                        $subject = trim($row[7]);

                        $circuit_ids = isset($row[1]) ? explode(';', $row[1]) : [];
                        $circuit_ids = array_filter(array_map('trim', $circuit_ids));

                        $addressService = isset($row[2]) ? $row[2] : '';
                        $addressesServices = explode(';', $addressService);
                        $addresses = [];
                        $services = [];

                        foreach ($addressesServices as $index => $addressOrService) {
                            if ($index % 2 === 0) {
                                $addresses[] = trim($addressOrService);
                            } else {
                                $services[] = trim($addressOrService);
                            }
                        }

                        $sendEmail = new SendMailableClass($row, $language, $subject, $addresses, $services, $circuit_ids);
                        $previewEmails[] = $sendEmail->render();
                    }
                } else {
                  
                    continue;
                }

    
            }
        }

        return view('previewEmails', compact('previewEmails'));
    } else {
        $status = 'No Excel files found';
        $previewEmails = [];
        return view('previewEmails', compact('previewEmails', 'status'));
    }
}

public function sendMultipleEmails()
{
    $directoryPath = storage_path('app/excel');
    $excelData = $this->getExcelDataFromDirectory($directoryPath);

    $success = true;

 

    foreach ($excelData as $data) {
        $skipFirstRow = true; // Flag to skip the first row

        if (!empty($data)) {
            $filteredData = array_filter($data, function($row) {
                return !empty(array_filter($row));
            });

            if (!empty($filteredData)) {
                foreach ($filteredData as $row) {
                    $emails = explode(';', $row[0] ?? '');
                    $emails = array_filter(array_map('trim', $emails));


                          // Skip the first row from excel table
                            if ($skipFirstRow) {
                                $skipFirstRow = false;
                                continue;
                            }

                    if (!empty($emails)) {
                        $language = strtolower(trim($row[6] ?? ''));
                       
                        $subject = trim(($row[7] ?? '') . ($row[8] ?? '')); // merge rows of Subject
                        $circuit_ids = explode(';', $row[1] ?? '');
                        $circuit_ids = array_filter(array_map('trim', $circuit_ids));

                        $addressService = $row[2] ?? '';
                        $addressesServices = explode(';', $addressService);
                        $addresses = [];
                        $services = [];

                        foreach ($addressesServices as $index => $addressOrService) {
                            if ($index % 2 === 0) {
                                $addresses[] = trim($addressOrService);
                            } else {
                                $services[] = trim($addressOrService);
                            }
                        }
                      //  $to = implode(', ', $emails); --> ne mora implode posto koga se praka array avtomatski stava zapirki megju meilovite 
                        try {
                            Mail::to($emails)->send(new SendMailableClass($row, $language, $subject, $addresses, $services, $circuit_ids));
                        } catch (ValidationException $e) {
                            $success = false; // Set flag to false if sending email fails
                        }

                     }
                }
            } else {
                return redirect()->route('index.page')->with('status', 'No data found');
            }
        }
    }

    $this->store();
    $this->deleteExcelFileWhenSentEmails();

    if ($success) {
        return redirect()->route('index.page')->with('status', 'Emails have been sent successfully and Excel Table has been deleted');
    } else {
        return redirect()->route('index.page')->with('error', 'Failed to send all emails');
    }
}





private function deleteExcelFileWhenSentEmails()
{
    $filePath = storage_path('app/excel');

    if (file_exists($filePath)) {
        File::deleteDirectory($filePath);
        return redirect()->route('index.page')->with('status', 'Emails have been sent succesfully and Excel table deleted successfully');
    } else {
        return redirect()->route('index.page')->with('error', 'Excel file not found');
    }
}



private function getExcelDataFromDirectory($directoryPath)
{
    $excelData = [];

    if (file_exists($directoryPath)) {
        $files = scandir($directoryPath);

        foreach ($files as $file) {
            if ($file == '.' || $file == '..') continue;

            $filePath = $directoryPath . '/' . $file;
            $data = Excel::toArray(new Import(), $filePath);
       
            if (!empty($data[0])) {
                $excelData[] = $data[0];
            }
        }
    }

    return $excelData;
}

private function store()
{
    $directoryPath = storage_path('app/excel');
    $excelData = $this->getExcelDataFromDirectory($directoryPath);

    foreach ($excelData as $rows) {

        $filteredData = array_filter($rows, function($row) {
            return !empty(array_filter($row));
        });
        
        if (!empty($filteredData)) {
            foreach ($filteredData as $row) { 
           
              
                $emails = $row[0] ?? '';
                $korisnik = $row[1] ?? '';
                $adresa_servis = $row[2] ?? '';
                $pocetok = $row[3] ?? '';
                $kraj = $row[4] ?? '';
                $vremetraenje = $row[5] ?? '';
                $verzija = $row[6] ?? '';
                $naslov = $row[7] ?? '';
                $prva_recenica = $row[8] ?? '';
                $pricina = $row[9] ?? '';

                if (SentEmailModel::create([
                    'emails' => $emails,
                    'korisnik' => $korisnik,
                    'adresa_servis' => $adresa_servis, 
                    'pocetok' => $pocetok,
                    'kraj' => $kraj,
                    'vremetraenje' => $vremetraenje,
                    'verzija' => $verzija,
                    'naslov' => $naslov,
                    'prva_recenica' => $prva_recenica,
                    'pricina' => $pricina
                 
                ])) {
                    Log::info('Successfully stored email: ' . $emails);
                }
            }
        }
    }
}}