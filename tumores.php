<?php
ini_set('memory_limit', '-1');
$row = 0;
$count = 1;
$doOnce = false;
// $patientNo = 0;

$patientFile = new SplFileObject('paciente_output.csv', 'r');
$patientFile->seek(PHP_INT_MAX);

$tumourCount = 1;
if (($handle = fopen("paciente_output.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
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
// var_dump("LIMIT MAX: " . $patientFile->key());
for ($i = 0; $i < $patientFile->key(); $i++) {
    $row = 0;
    if (($handle1 = fopen("tumor.csv", "r")) !== FALSE) {

        while (($data = fgetcsv($handle1, 1000, ",")) !== FALSE) {

            if ($row == 0 && !$doOnce) {
                $doOnce = true;
                $data[] = "Tumour ID";
                $data[] = "Patient ID Tumour Table";
                $data[] = "Patient Record ID Tumour Table";
                $newData[] = $data;
            }

            if ($row > 0) {
                if ($data[17] != $tumourData[$row - 1][17]) {
                    $count = 1;
                } else {
                    $count++;
                }
            }

            if ($data[17] == $patientData[$i][0]) {
                if ($count < 10) {
                    $data[] = $patientData[$i][50] . 0 . $count;
                } else {
                    $data[] = $patientData[$i][50] . $count;
                }

                $data[] = $patientData[$i][49];
                $data[] = $patientData[$i][50];
                $data[16] = preg_replace("/(\r\n|\n|\r)/", " ",$data[16]);
                $newData[] = $data;
                // var_dump($patientData[$i][50]);
                // var_dump($patientData[$i][49]);
                // var_dump($data);
            }
            $row++;
            $tumourData[] = $data;
        }

        fclose($handle1);
    }
}

// var_dump($tumourData);
// var_dump($newData);

$handle = fopen('tumor_output.csv', 'w');

foreach ($newData as $line) {
    fputcsv($handle, $line);
}

fclose($handle);

include ("study_separator.php");

// var_dump($newData);
//fulcrum id    [ 0]
//observaciones [16]
//ptnt fulcr.id [17]  //Previously 16  
//fuente id     [49]
//tumour id     [50]  //record id tbl + tumour no.
//id tmr table  [51]  //Igual a registry number
//record id tbl [52]  //Igual a ptnt record id

// var_dump($patientData);
//fulcrum id     [ 0]
//registry no.   [49]  //Previously 57
//ptnt record id [50]  //Previously 58