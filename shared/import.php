<?php
include './connection.php';

require_once '../vendor/autoload.php';
 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


if (isset($_POST['submit'])) { // Check if the form was submitted
    if ($_FILES['excel_file']['error'] !== UPLOAD_ERR_OK) {
        // Handle the file upload error here
        echo 'File upload error: ' . $_FILES['excel_file']['error'];

    } else {
        $uploadedFile = $_FILES['excel_file']['tmp_name'];
        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($uploadedFile);
            $sheetCount = $spreadsheet->getSheetCount();
            $allData = [];
    
            for ($i = 0; $i < $sheetCount; $i++) {
                $sheet = $spreadsheet->getSheet($i);
                $data = $sheet->toArray();
                $allData[] = $data; // Store the data from each sheet
    
                // Process $data as needed for each sheet
                // Example: You can insert data into a database here
                // For database insertion, you would typically loop through the $data array and execute SQL queries
                // Example: foreach ($data as $row) { /* Execute SQL query here */ }
            }
            print_r($allData);
            // Now you have all the sheet data in the $allData variable
            // You can perform further processing or database operations here
    
            echo 'Data imported successfully!';
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            echo 'Error loading Excel file: ' . $e->getMessage();
        }
    }

    
}

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