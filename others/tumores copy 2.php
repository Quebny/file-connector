<?php

$row = 0;
$patientNo = 0;
$patientData;
$file = new SplFileObject('paciente_test_output.csv', 'r');
$file->seek(PHP_INT_MAX);
if (($handle1 = fopen("paciente_test_output.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle1, 1000, ",")) !== FALSE) {
        $patientData[] = $data;
    }
    fclose($handle1);
}

if (($handle2 = fopen("tumor_test_input.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle2, 1000, ",")) !== FALSE) {
        if ($row == 0) {
            $data[] = "Tumour ID";
            $data[] = "Patient ID Tumour Table";
            $data[] = "Patient Record ID Tumour Table";
            // } else if ($row < 10) {
            //     if ($data[16] == $patientData[$row-1][0]) {
            //         $data[] = $patientData[$row-1][57];
            //     }
            // } else {
            //     $data[] = 202200 . $row;
            //     $data[] = 202200 . $row . 0 . 1;
        }
        $tumoursData[] = $data;

        if ($patientNo <> $file->key() + 1 && $row > 0) {
            // for ($i = 0; $i < $file->key(); $i++) {
                if ($patientData[$patientNo][0] == $data[16]) {
                    $data[] = $patientData[$patientNo][57];
                } else {
                    $patientNo++;
                }
                // var_dump($patientData[$patientNo][0]);
            // }
        }

       



        $row++;
    }
    fclose($handle2);
}

$handle = fopen('tumor_test_output.csv', 'w');

foreach ($tumoursData as $line) {
    fputcsv($handle2, $line);
}

fclose($handle);

$str = "Patient Row Size: ";
echo $str . $file->key();
// var_dump($tumoursData);
//fulcrum id    [ 0]
//ptnt fulcr.id [16]  
//fuente id     [49]
//tumour id     [50]  //record id tbl + tumour no.
//id tmr table  [51]  //Igual a registry number
//record id tbl [52]  //Igual a ptnt record id

// var_dump($patientData)
//fulcrum id     [ 0]
//registry no.   [57]
//ptnt record id [58]