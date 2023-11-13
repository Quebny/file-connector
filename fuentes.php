<?php
ini_set('memory_limit', '-1');
ini_set('max_input_time', '-1');
ini_set('max_execution_time', '-1');
set_time_limit(0);

$fuenteFile = new SplFileObject('fuente.csv', 'r');
$fuenteFile->setFlags(SplFileObject::READ_CSV);

$tumourFile = new SplFileObject('tumor_output_2.csv', 'r');
$tumourFile->setFlags(SplFileObject::READ_CSV);

$newData = array();
$count = 0;
$doOnce = true;

$reset = false;

foreach ($fuenteFile as $fuenteData) {
    if ($doOnce) {
        $fuenteData[] = "Tumor ID Source Table";
        $fuenteData[] = "Source Record ID";
        $newData[] = $fuenteData;
        $doOnce = false;
    }

    foreach ($tumourFile as $tumourData[]) {

        if (isset($tumourData[$tumourFile->key()][76]) && $fuenteData[0] == $tumourData[$tumourFile->key()][76]) {

            if ($tumourData[$fuenteFile->key()][0] == $tumourData[$fuenteFile->key() - 1][0] || $tumourData[$fuenteFile->key() - 1][0] == 'fulcrum_id') {
                $count++;
            } else {
                $count = 1;
            }

            if (isset($fuenteData[0], $tumourData[$fuenteFile->key()][77])) {
                $combinedData = array_merge($fuenteData, array(
                    ($count < 10) ? $tumourData[$fuenteFile->key()][77] . '0' . $count : $tumourData[$fuenteFile->key()][77] . $count,
                    $tumourData[$fuenteFile->key()][77]
                ));
                $newData[] = $combinedData;
            }
        }
    }
}

$outputFile = new SplFileObject('fuente_output.csv', 'w');

foreach ($newData as $line) {
    $outputFile->fputcsv($line);
}

echo "Processing complete.\n";
