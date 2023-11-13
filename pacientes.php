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
                } elseif ($row < 100) {
                    $data[] = 202200 . $row;
                    $data[] = 202200 . $row . 0 . 1;
                } elseif ($row < 1000) {
                    $data[] = 20220 . $row;
                    $data[] = 20220 . $row . 0 . 1;
                } else {
                    $data[] = 2022 . $row;
                    $data[] = 2022 . $row . 0 . 1;
                }
                $data[43] = preg_replace("/(\r\n|\n|\r)/", " ", $data[43]);
            }
            fputcsv($handle2, $data);

            $patientIDs[] = $data;
            $row++;
        }
        fclose($handle2);
    }
    fclose($handle);
}
