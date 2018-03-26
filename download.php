<?php

require_once 'config.php';

    $sql = "SELECT * FROM clientinfo";
    $result = mysqli_query($mysqli, $sql) or die("could not perform query");

    $rows = array();
    $i = 0;
    while($row = mysqli_fetch_assoc($result)){ // loop to store the data in an associative array.
        $rows[$i] = $row;
        $i++;
    }

    $fileName = 'clientInfo.csv';
 
    //Set the Content-Type and Content-Disposition headers to force the download.
    header('Content-Type: application/excel');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    
    //Open up a file pointer
    $fp = fopen('php://output', 'w');
    
    //Then, loop through the rows and write them to the CSV file.
    foreach ($rows as $row) {
        fputcsv($fp, $row);
    }
    
    //Close the file pointer.
    fclose($fp);