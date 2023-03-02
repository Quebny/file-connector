<?php
ini_set('memory_limit', '-1');
$row = 0;
$count = 1;
$doOnce = false;

$tumourFile = new SplFileObject('tumor_output.csv', 'r');
$tumourFile->seek(PHP_INT_MAX);
if (($handle = fopen("tumor_output_2.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $tumourData[] = $data;
    }
    fclose($handle);
}

$newData = array();
for ($i = 0; $i < $tumourFile->key(); $i++) {
    $row = 0;
    if (($handle = fopen("fuente.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($row == 0 && !$doOnce) {
                $doOnce = true;
                $data[] = "Tumor ID Source Table";
                $data[] = "Source Record ID";
                $newData[] = $data;
            }

            if ($row > 0) {
                if ($data[0] != $tumourData[$row - 1][53]) {
                    $count = 1;
                } else {
                    $count++;
                }
            }

            if ($data[0] == $tumourData[$i][53]) {
                $sourceNum = substr($tumourData[$i][54], -2);
                if ($count < 10) {
                    $data[] = $tumourData[$i][56] . 0 . $count;
                } else {
                    $data[] = $tumourData[$i][56] . $count;
                }

                $data[] = $tumourData[$i][55];

                $newData[] = $data;
            }

            $fuentesData[] = $data;

            $row++;
        }
        fclose($handle);
    }
}

$handle = fopen('fuente_output.csv', 'w');

foreach ($newData as $line) {
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
//studio id  [53]
//tumour id  [54]
//tumour tbl [55]
//ptn rec id [56]