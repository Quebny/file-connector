<?php
ini_set('memory_limit', '-1');
ini_set('max_input_time', '-1');
ini_set('max_execution_time', '-1');
set_time_limit(0);

$tumourFile = new SplFileObject('tumor.csv', 'r');
$tumourFile->setFlags(SplFileObject::READ_CSV);

$patientFile = new SplFileObject('paciente_output.csv', 'r');
$patientFile->setFlags(SplFileObject::READ_CSV);

$newData = array();
$doOnce = true;


foreach ($tumourFile as $tumourData) {

    if ($doOnce) {
        $tumourData[] = "Tumour ID";
        $tumourData[] = "Patient ID Tumour Table";
        $tumourData[] = "Patient Record ID Tumour Table";
        $newData[] = $tumourData;
        $doOnce = false;
    }

    $count = 0;

    foreach ($patientFile as $patientData) {
        if ($patientFile->key() == 0) {
            continue;
        }

        if (isset($tumourData[24]) && $tumourData[24] == $patientData[0]) {
            $count = ($tumourData[24] != $tumourData[23]) ? 1 : $count + 1;

            $combinedData = array_merge($tumourData, array(
                ($count < 10) ? $patientData[56] . '0' . $count : $patientData[56] . $count,
                $patientData[55],
                $patientData[56]
            ));

            $newData[] = $combinedData;
        }
    }
}

$outputFile = new SplFileObject('tumor_output.csv', 'w');

foreach ($newData as $line) {
    $outputFile->fputcsv($line);
}

echo "Processing complete.\n";

include("study_separator.php");
