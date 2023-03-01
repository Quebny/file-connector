<?php

$row = 0;
$tumourData;
$fuenteCount = 1;
// $fuenteCount = 1;
if (($handle = fopen("tumor_output.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $tumourData[] = $data;
    }
    fclose($handle);
}

if (($handle = fopen("fuente.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($row == 0) {
            $data[] = "Tumor ID Source Table";
            $data[] = "Source Record ID";
        } else {

            var_dump("CURRENT: " . $data[1]);
            var_dump("PREVIOUS: " . $fuentesData[$row - 1][1]);
            var_dump("--------------------------------------------------------");

            if ($data[0] != $fuentesData[$row - 1][0]) {
                $fuenteCount++;
            }
            if ($data[1] != $fuentesData[$row - 1][1]) {
                $fuenteCount = 1;
            }

            $data[] = $tumourData[$row][51];
            if ($row < 10)
                $data[] = $tumourData[$row][51] . 0 . $fuenteCount;
            else
                $data[] = $tumourData[$row][51] . $fuenteCount;
        }

        $fuentesData[] = $data;

        $row++;
    }
    fclose($handle);
}

$handle = fopen('fuente_output.csv', 'w');

foreach ($fuentesData as $line) {
    fputcsv($handle, $line);
}

fclose($handle);

// $str = "Patient Row Size: ";
// echo $str . $patientFile->key();

// var_dump($fuentesData);
//fulcrum_id [ 0]
//tumor id   [ 1]
//id src tbl [21] //Igual a tumor id
//src rec id [22]

// var_dump($tumourData);
//fulcrum_id [ 0]
//tumor id   [51]
//--- [  ]