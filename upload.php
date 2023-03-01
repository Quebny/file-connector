<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    $filename = $_FILES['file']['name'];

    switch ($filename) {
        case "paciente.csv":
            $location = $filename;
            $file = "pacientes";
            break;
        case "tumor.csv":
            $location = $filename;
            $file = "study_separator";
            break;
        case "fuente.csv":
            $location = $filename;
           $file = "fuentes";
            break;
        default:
            $location = "";
            break;
    }

    if ($location != "") {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
            echo '<p>File uploaded succesfully</p>';
            include $file.".php";
        } else {
            echo '<b>Error uploading file</b>';
        }
    } else
        echo '<b>Wrong filename</b>';

    ?>

</body>

</html>