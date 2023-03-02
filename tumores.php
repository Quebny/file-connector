<?php
ini_set('memory_limit', '-1');
$row = 0;
$count = 1;
$doOnce = false;
// $patientNo = 0;

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

$newData = array();
for ($i = 0; $i < $patientFile->key(); $i++) {
    $row = 0;
    if (($handle1 = fopen("tumor_output.csv", "r")) !== FALSE) {
        // if (($handle2 = fopen("tumor_output_2.csv", "w")) !== FALSE) {

        while (($data = fgetcsv($handle1, 1000, ",")) !== FALSE) {

            if ($row == 0 && !$doOnce) {
                $doOnce = true;
                $data[] = "Tumour ID";
                $data[] = "Patient ID Tumour Table";
                $data[] = "Patient Record ID Tumour Table";
                $newData[] = $data;
            }

            if ($row > 0) {

                // if ($data[0] != $tumourData[$row - 1][0]) {
                //     $count++;
                // }
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
                $newData[] = $data;
                // var_dump($patientData[$i][50]);
                // var_dump($patientData[$i][49]);
                // var_dump($data);
            }

            $row++;
            // fputcsv($handle2, $data);

            $tumourData[] = $data;
        }
        //     fclose($handle2);
        // }

        fclose($handle1);
    }
}

// var_dump($tumourData);
// var_dump($newData);

$handle = fopen('tumor_output_2.csv', 'w');

foreach ($newData as $line) {
    fputcsv($handle, $line);
}

fclose($handle);




// if (($handle = fopen("tumor_output.csv", "r")) !== FALSE) {
//     if (($handle2 = fopen("paciente_output.csv", "w")) !==)

//         while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
//             include("pacientes.php");

//             if ($row == 0) {
//                 $data[] = "Tumour ID";
//                 $data[] = "Patient ID Tumour Table";
//                 $data[] = "Patient Record ID Tumour Table";
//             } else {

//                 var_dump($patientIDs);

//                 // if ($data[0] != $tumoursData[$row - 1][0]) {
//                 //     $tumourCount++;
//                 // }
//                 // if ($data[17] != $tumoursData[$row - 1][17]) {
//                 //     $tumourCount = 1;
//                 // } else {
//                 //     $tumourCount++;
//                 // }

//                 // if ($patientData[$patientNo][0] != $data[17]) {
//                 //     $patientNo++;
//                 // }

//                 // if ($tumourCount < 10)
//                 //     $data[] = $patientData[$patientNo][50] . 0 . $tumourCount;
//                 // else
//                 //     $data[] = $patientData[$patientNo][50] . $tumourCount;

//                 // // $data[] = $patientData[$patientNo][49];
//                 // $data[] = $patientData[$patientNo][50];    

//                 // var_dump($patientData[$patientNo][0]);
//             }

//             $tumoursData[] = $data;

//             $row++;
//         }

//     fclose($handle);
// }

// $handle = fopen('tumor_output.csv', 'w');

// foreach ($tumoursData as $line) {
//     fputcsv($handle, $line);
// }

// fclose($handle);

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