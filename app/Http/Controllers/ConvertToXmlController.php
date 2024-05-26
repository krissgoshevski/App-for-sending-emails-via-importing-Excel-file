<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Import;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;



use PhpOffice\PhpSpreadsheet\IOFactory;


class ConvertToXmlController extends Controller
{


public function downloadXml()
{
    $xmlFilePath = storage_path('app/public/new_DD_I.xml'); // vo ovaa pateka da se download


    if (file_exists($xmlFilePath)) {
        return Response::download($xmlFilePath, 'new_DD_I.xml', ['Content-Type: text/xml']);
    } else {
        return redirect()->route('xml')->with('error', 'XML file not found.');
    }
}



public function toXML()
{
    try {
        $filePath = storage_path('app/public/ddi_calc_final.xlsx');

        if (!file_exists($filePath)) {
            throw new \Exception('Excel file not found.');
        }

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        $xmlFilePath = storage_path('app/public/new_DD_I.xml');
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        xmlwriter_set_indent_string($xw, ' ');
        xmlwriter_start_document($xw, '1.0', 'UTF-8');

        xmlwriter_start_element($xw, 'dd_i_2023');

        xmlwriter_write_element($xw, 'ujp_prijava_broj', $data[1][0]);
        xmlwriter_write_element($xw, 'edb', $data[1][1]);
        xmlwriter_write_element($xw, 'datum_od', $data[1][2]);
        xmlwriter_write_element($xw, 'do_datum', $data[1][3]);
        xmlwriter_write_element($xw, 'naziv_adresa_sediste', $data[1][4]);
        xmlwriter_write_element($xw, 'rok_za_podnesuvanje', $data[1][5]);
        xmlwriter_write_element($xw, 'ispravka', $data[1][6]);
        xmlwriter_write_element($xw, 'datumpriem', $data[1][7]);
        xmlwriter_write_element($xw, 'telefon', $data[1][8]);
        xmlwriter_write_element($xw, 'email', $data[1][9]);

        foreach (array_slice($data, 9) as $index => $row) {
            if (!empty(array_filter($row))) {
                xmlwriter_start_element($xw, 'dd_i_dynamic');
                xmlwriter_start_attribute($xw, 'id');
                xmlwriter_text($xw, $index + 1);
                xmlwriter_end_attribute($xw);

                xmlwriter_write_element($xw, 'edb', $row[1]);
                xmlwriter_write_element($xw, 'poln_naziv', $row[2]);
                xmlwriter_write_element($xw, 'adresni_podatoci', $row[3]);
                xmlwriter_write_element($xw, 'pravna_forma', $row[4]);
                xmlwriter_write_element($xw, 'drzava_rezident', $row[5]);
                xmlwriter_write_element($xw, 'vid_prihod', $row[6]);
                xmlwriter_write_element($xw, 'iznos_prihod_zadrska', $row[7]);
                xmlwriter_write_element($xw, 'procent_od_zdd', $row[8]);
                xmlwriter_write_element($xw, 'iznos_zadrzi', $row[9]);
                xmlwriter_write_element($xw, 'data_pristignuvanje_obvrska', $row[10]);
                xmlwriter_write_element($xw, 'procent_od_dogovor', $row[11]);
                xmlwriter_write_element($xw, 'iznos_danok_zadrzan_uplaten', $row[12]);
                xmlwriter_write_element($xw, 'data_uplata_danok', $row[13]);

                xmlwriter_end_element($xw);
            }
        }

        xmlwriter_write_element($xw, 'sostavuvac_ime', $data[4][0]);
        xmlwriter_write_element($xw, 'sostavuvac_prezime', $data[4][1]);
        xmlwriter_write_element($xw, 'sostavuvac_edb', $data[4][2]);
        xmlwriter_write_element($xw, 'popolnuvac_svojstvo', $data[4][3]);
        xmlwriter_write_element($xw, 'datumpopolnuvanje', $data[4][4]);
        xmlwriter_write_element($xw, 'odgovoren_ime', $data[4][5]);
        xmlwriter_write_element($xw, 'odgovoren_prezime', $data[4][6]);
        xmlwriter_write_element($xw, 'odgovoren_edb', $data[4][7]);
        xmlwriter_write_element($xw, 'odgovoren_svojstvo', $data[4][8]);
        xmlwriter_write_element($xw, 'datumpriem', $data[4][9]);
        xmlwriter_write_element($xw, 'pecat', $data[4][10]);
        xmlwriter_write_element($xw, 'zabeleska', $data[4][11]);

        xmlwriter_end_element($xw);

        xmlwriter_end_document($xw);

        $xmlContent = xmlwriter_output_memory($xw);
        file_put_contents($xmlFilePath, $xmlContent);

        return response()->view('xml', compact('xmlContent'));
    } catch (\Exception $e) {
        Log::error('Error converting Excel to XML: ' . $e->getMessage());
        return redirect()->route('xml')->with('error', 'An error occurred while converting the Excel file to XML.');
    }
}



   
}
