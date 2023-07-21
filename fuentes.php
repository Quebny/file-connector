<?php
ini_set('memory_limit', '-1');
set_time_limit(300);
$row = 0;
$count = 1;
$doOnce = false;

$tumourFile = new SplFileObject('tumor_output_2.csv', 'r');
$tumourFile->seek(PHP_INT_MAX);
if (($handle = fopen("tumor_output_2.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
        $tumourData[] = $data;
    }
    fclose($handle);
}


$newData = array();
for ($i = 0; $i < 3349; $i++) {
    $row = 0;
    if (($handle = fopen("fuente.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
            if ($row == 0 && !$doOnce) {
                $doOnce = true;
                $data[] = "Tumor ID Source Table";
                $data[] = "Source Record ID";
                $newData[] = $data;
            }

            if ($data[0] == $tumourData[$i][75]) {
                if ($count < 10) {
                    $data[] = $tumourData[$i][76] . 0 . $count;
                } else {
                    $data[] = $tumourData[$i][76] . $count;
                }

                $data[] = $tumourData[$i][76];

                $newData[] = $data;

                if ($row > 0) {
                    // var_dump("VAR 1: " . $newData[$i-1][22]);
                    // var_dump("VAR 2: " . $tumourData[$i][54]);
                    // var_dump("----------------------------------------------------------------");
                    if ($newData[$i][27] != $tumourData[$i - 1][76]) {
                        $count = 1;
                    } else {
                        $count++;
                    }
                }
            }
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

// var_dump($newData[2]);
// var_dump($tumourData[1]);
//fulcrum_id [ 0]
//tumor id   [ 1]
//descripcion[19]
//id src tbl [21] //Igual a tumor id
//src rec id [22]

// var_dump($tumourData);

//fulcrum_id [ 0]
//studio id  [53]
//tumour id  [54]
//tumour tbl [55]
//ptn rec id [56]