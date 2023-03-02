<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn)
    die("Conexión fallida: " . mysqli_connect_error());

$table_name = "paciente";

$file_name = "paciente.csv";

$registryNumber = "registry_number";
$patientRecordID = "patient_record_id";

// $sql_add_column = "ALTER TABLE " . $table_name . " ADD COLUMN (" . $registryNumber . " INT(8) UNSIGNED, " . $patientRecordID . " INT(10) UNSIGNED)";

// mysqli_query($conn, $sql_add_column);

$file = fopen($file_name, "r");
$row = 0;
while (($data = fgetcsv($file)) !== FALSE) {
    if ($row != 0) {

        // $sql_insert_row = "INSERT INTO " . $table_name . " (registry_number, patient_record_id) VALUES ('" . 202200 . 0 . $row . "', '" . 202200 . $row . 0 . 1 . "')";

        // mysqli_query($conn, $sql_insert_row);

        

        $new_id1 = mysqli_insert_id($conn);
        $new_id2 = mysqli_insert_id($conn);

        $sql_update_columns = "UPDATE " . $table_name . " SET " . $registryNumber . " = " . 20220 . 0 . $row . ", " . $patientRecordID . " = " . 202200 . $row . 0 . 1 . " WHERE fulcrum_id = " . $new_id1;
        mysqli_query($conn, $sql_update_columns);
    }
    $row++;
}

fclose($file);

mysqli_close($conn);
