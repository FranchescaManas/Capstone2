<?php
include './connection.php';
include '../phpspreadsheet/src/Bootstrap.php';
include '../phpspreadsheet/src/IOFactory.php';


$samplefile = '../import-template/Student Template 1.xlsx';

function importStudent($request){

    try {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request);
        $sheetCount = $spreadsheet->getSheetCount();

        for ($i = 0; $i < $sheetCount; $i++) {
            $sheet = $spreadsheet->getSheet($i);
            $data = $sheet->toArray(); // Get the data from each sheet as an array

            // Process $data as needed for each sheet
            // Example: print_r($data);
        }
    } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        echo 'Error loading Excel file: ' . $e->getMessage();
    }




}

?>