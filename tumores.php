<?php
ini_set('memory_limit', '-1');
ini_set('max_input_time', '-1');
ini_set('max_execution_time', '-1');
set_time_limit(300);
$row = 0;
$count = 1;
$doOnce = false;
// $patientNo = 0;

$patientFile = new SplFileObject('paciente_output.csv', 'r');
$patientFile->seek(PHP_INT_MAX);

$tumourCount = 1;
if (($handle = fopen("paciente_output.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
        $patientData[] = $data;
    }
    fclose($handle);
}

// if (($handle1 = fopen("tumor.csv", "r")) !== FALSE){
//     while (($data = fgetcsv($handle1, 1000, ","))!== FALSE) {
//         $data[16] = preg_replace("/(\r\n|\n|\r)/", " ",$data[16]);
//     }
//     fclose($handle1);
// }


$newData = array();
// var_dump($patientFile->key());

for ($i = 0; $i < 802; $i++) {
    $row = 0;
    if (($handle1 = fopen("tumor.csv", "r")) !== FALSE) {

        while (($data = fgetcsv($handle1, 0, ",")) !== FALSE) {
            if ($row == 0 && !$doOnce) {
                $doOnce = true;
                $data[] = "Tumour ID";
                $data[] = "Patient ID Tumour Table";
                $data[] = "Patient Record ID Tumour Table";
                $newData[] = $data;
            }

            if ($row > 0) {
                if ($data[27] != $tumourData[$row - 1][17]) {
                    $count = 1;
                } else {
                    $count++;
                }
            }

            if ($data[27] == $patientData[$i][0]) {
                if ($count < 10) {
                    $data[] = $patientData[$i][58] . 0 . $count;
                } else {
                    $data[] = $patientData[$i][58] . $count;
                }

                $data[] = $patientData[$i][57];
                $data[] = $patientData[$i][58];
                // $data[16] = preg_replace("/(\r\n|\n|\r)/", " ",$data[16]);
                $newData[] = $data;
            }
            $row++;
            $tumourData[] = $data;
        }
    }
    fclose($handle1);
}
// }


$handle = fopen('tumor_output.csv', 'w');

foreach ($newData as $line) {
    fputcsv($handle, $line);
}

fclose($handle);

include("study_separator.php");

// var_dump($newData);
//fulcrum id    [ 0]
//observaciones [16]
//ptnt fulcr.id [27] 17
//fuente id     [49] 71
//tumour id     [50] 72 //record id tbl + tumour no.
//id tmr table  [51] 73 //Igual a registry number
//record id tbl [52] 74 //Igual a ptnt record id

// var_dump($patientData);
//fulcrum id     [ 0]
//registry no.   [49]  //Previously 57
//ptnt record id [50]  //Previously 58