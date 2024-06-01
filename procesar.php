<?php

require "vendor/autoload.php";

$client = new nusoap_client("http://192.168.74.169/webservice/ws2.php?wsdl", true);

$error = $client->getError();
if ($error) {
    echo "<h2>Error en la construcción del cliente</h2><pre>" . $error . "</pre>";
    die();
}


if (isset($_POST['nombre']) && isset($_POST['lab1']) && isset($_POST['lab2']) && isset($_POST['parcial'])) {
    $nombre = $_POST['nombre'];
    $lab1 = (float)$_POST['lab1'];
    $lab2 = (float)$_POST['lab2'];
    $parcial = (float)$_POST['parcial'];

   
    $result = $client->call("registrarAlumno", array(
        "Nombre" => $nombre,
        "Laboratorio1" => $lab1,
        "Laboratorio2" => $lab2,
        "Parcial" => $parcial
    ));

   
    if ($client->fault) {
        echo "<h2>Fallo</h2><pre>";
        print_r($result);
        echo "</pre>";
    } else {
        $error = $client->getError();
        if ($error) {
            echo "<h2>Error en la respuesta</h2><pre>" . $error . "</pre>";
        } else {
            echo "<h2>Alumno Registrado</h2>";
            echo '<table border="1" cellpadding="10" cellspacing="0" style="margin: auto; border-collapse: collapse; width: 50%;">';
            echo '<tr><th>Campo</th><th>Datos</th></tr>';
            echo '<tr><td>Nombre</td><td>' . htmlspecialchars($result['Nombre']) . '</td></tr>';
            echo '<tr><td>Laboratorio 1</td><td>' . htmlspecialchars($result['Laboratorio1']) . '</td></tr>';
            echo '<tr><td>Laboratorio 2</td><td>' . htmlspecialchars($result['Laboratorio2']) . '</td></tr>';
            echo '<tr><td>Parcial</td><td>' . htmlspecialchars($result['Parcial']) . '</td></tr>';
            echo '<tr><td>Promedio</td><td>' . htmlspecialchars($result['Promedio']) . '</td></tr>';
            echo '</table>';
        }
    }
} else {
    echo "<h2>Error</h2><pre>Datos incompletos en el formulario.</pre>";
}

?>











