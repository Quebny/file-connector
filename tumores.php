<?php

$row = 0;
$patientNo = 0;
$patientData;
$patientFile = new SplFileObject('paciente_output.csv', 'r');
$patientFile->seek(PHP_INT_MAX);
$tumourFile = new SplFileObject('tumor_output.csv', 'r');
$tumourFile->seek(PHP_INT_MAX);
$tumourCount = 1;
if (($handle = fopen("paciente_output.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $patientData[] = $data;
    }
    fclose($handle);
}

if (($handle = fopen("tumor_output.csv", "r")) !== FALSE) {
    for ($i = 0; $i < $patientFile->key(); $i++) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($row == 0) {
                $data[] = "Tumour ID";
                $data[] = "Patient ID Tumour Table";
                $data[] = "Patient Record ID Tumour Table";
            } else {

                if ($data[0] != $tumoursData[$row - 1][0]) {
                    $tumourCount++;
                }
                if ($data[17] != $tumoursData[$row - 1][17]) {
                    $tumourCount = 1;
                } else {
                    $tumourCount++;
                }

                if ($patientData[$patientNo][0] != $data[17]) {
                    $patientNo++;
                }

                // if ($tumourCount < 10)
                //     $data[] = $patientData[$patientNo][50] . 0 . $tumourCount;
                // else
                //     $data[] = $patientData[$patientNo][50] . $tumourCount;

                // // $data[] = $patientData[$patientNo][49];
                // $data[] = $patientData[$patientNo][50];    

                // var_dump($patientData[$patientNo][0]);
            }

            var_dump("NUMBER: " . $patientNo);
            $bruh = isset($patientData[$patientNo][0]);
            var_dump("TUMOUR PTN: " . $data[17]);
            if ($bruh) {
                var_dump("PATIENT ID: " . $patientData[$patientNo][0]);
            }
            var_dump("----------------------------------------------------------------");


            $tumoursData[] = $data;

            $row++;
        }
    }

    fclose($handle);
}

$handle = fopen('tumor_output.csv', 'w');

foreach ($tumoursData as $line) {
    fputcsv($handle, $line);
}

fclose($handle);

// $str = "Patient Row Size: ";
// echo $str . $patientFile->key();
// var_dump($tumoursData);
//fulcrum id    [ 0]
//ptnt fulcr.id [17]  //Previously 16  
//fuente id     [49]
//tumour id     [50]  //record id tbl + tumour no.
//id tmr table  [51]  //Igual a registry number
//record id tbl [52]  //Igual a ptnt record id

// var_dump($patientData);
//fulcrum id     [ 0]
//registry no.   [49]  //Previously 57
//ptnt record id [50]  //Previously 58