<?php
$previousID = null;
$patientIDs = array();
$row = 0;
if (($handle = fopen("paciente.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($row == 0) {
            $data[] = "Registry Number";
            $data[] = "Patient Record ID";
        } else {
            
            if ($row < 10)
                $data[] = 202200 . 0 . $row;
            else
                $data[] = 202200 . $row;

            $data[] = 202200 . $row . 0 . 1;
        }
        $patientIDs[] = $data;

        $row++;
    }
    fclose($handle);
}

$handle = fopen('paciente_output.csv', 'w');

foreach ($patientIDs as $line) {
    fputcsv($handle, $line);
}

fclose($handle);

// var_dump($patientIDs);
// echo $row;
