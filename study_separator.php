<?php

if (($handle1 = fopen("tumor_output.csv", "r")) !== FALSE) {
    if (($handle2 = fopen("tumor_output_2.csv", "w")) !== FALSE) {

        while (($data = fgetcsv($handle1, 1000, ",")) !== FALSE) {
            $array[] = $data;

            if (strpos($data[53], ",")) { //Previously 49
                $estudios = explode(",", $data[53]);
                
                foreach ($estudios as $id){
                    $data[53] = $id;
                    fputcsv($handle2, $data);
                }
            } else {
                fputcsv($handle2, $data);
            }
        }
        fclose($handle2);
    }
    fclose($handle1);
}

// include "tumores.php";

// var_dump($array);
