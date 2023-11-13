<?php
ini_set('memory_limit', '-1');
ini_set('max_input_time', '-1');
ini_set('max_execution_time', '-1');
set_time_limit(300);

if (($handle1 = fopen("tumor_output.csv", "r")) !== FALSE) {
    if (($handle2 = fopen("tumor_output_2.csv", "w")) !== FALSE) {

        while (($data = fgetcsv($handle1, 2000, ",")) !== FALSE) {
            $array[] = $data;

            if (strpos($data[76], ",")) { //Previously 49
                $estudios = explode(",", $data[76]);
                
                foreach ($estudios as $id){
                    $data[76] = $id;
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