<?php
$previousID = null;
$patientIDs = array();
$row = 0;
if (($handle = fopen("paciente.csv", "r")) !== FALSE) {
    if (($handle2 = fopen("paciente_output.csv", "w")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($row == 0) {
                $data[] = "Registry Number";
                $data[] = "Patient Record ID";
            } else {
                if ($row < 10) {
                    $data[] = 202200 . 0 . $row;
                    $data[] = 202200 . 0 . $row . 0 . 1;
                } else {
                    $data[] = 202200 . $row;
                    $data[] = 202200 . $row . 0 . 1;
                }
                $data[41] = preg_replace("/(\r\n|\n|\r)/", " ", $data[41]);
            }
            fputcsv($handle2, $data);

            $patientIDs[] = $data;
            $row++;
        }
        fclose($handle2);
    }
    fclose($handle);
}

// $handle = fopen('paciente_output.csv', 'w');

// foreach ($patientIDs as $line) {
//     fputcsv($handle, $line);
// }

// fclose($handle);

var_dump($patientIDs[129]);
// descripcion [41]
// echo $row;
