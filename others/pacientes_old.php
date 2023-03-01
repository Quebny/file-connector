<?php
$count = 0;
$idColumn;
$flag;

//Count file rows
$file = new SplFileObject('paciente_test_input.csv', 'r');
$file->seek(PHP_INT_MAX);

echo $file->key();
if (($handle1 = fopen("paciente_test_input.csv", "r")) !== FALSE) {
    if (($handle2 = fopen("paciente_test_output.csv", "w")) !== FALSE) {

        while (($data = fgetcsv($handle1, 1000, ",")) !== FALSE) {
            $array[] = $data;

            //Find fulcrum_id column
            if (str_contains($data[$count], 'fulcrum_id')) {
                $idColumn = $count;
                $flag = true;
            }

            //Add 01 to fulcrum_id columns
            if ($flag && !((str_contains($data[$count], 'fulcrum_id')))) {
                $data[$idColumn] = $data[$idColumn] . 0 . $count;
                fputcsv($handle2, $data);
            } else {
                fputcsv($handle2, $data);
            }

            $count++;
        }
        fclose($handle2);
    }
    fclose($handle1);
}

// var_dump($array);