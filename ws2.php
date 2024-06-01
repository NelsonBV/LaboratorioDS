<?php

require "vendor/autoload.php";

$server = new nusoap_server;
$server->configureWSDL('server', 'urn:server');
$server->wsdl->schemaTargetNamespace = 'urn:server';

$server->wsdl->addComplexType(
    'Alumno',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'Nombre' => array('name' => 'Nombre', 'type' => 'xsd:string'),
        'Laboratorio1' => array('name' => 'Laboratorio1', 'type' => 'xsd:float'),
        'Laboratorio2' => array('name' => 'Laboratorio2', 'type' => 'xsd:float'),
        'Parcial' => array('name' => 'Parcial', 'type' => 'xsd:float'),
        'Promedio' => array('name' => 'Promedio', 'type' => 'xsd:float')
    )
);

$server->register(
    'registrarAlumno',
    array('Nombre' => 'xsd:string', 'Laboratorio1' => 'xsd:float', 'Laboratorio2' => 'xsd:float', 'Parcial' => 'xsd:float'),
    array('return' => 'tns:Alumno'),
    'urn:server',
    'urn:server#registrarAlumnoServer',
    'rpc',
    'encoded',
    'Función para registrar alumno y calcular el promedio'
);

function registrarAlumno($Nombre, $Laboratorio1, $Laboratorio2, $Parcial) {
    $Promedio = ($Laboratorio1 * 0.25) + ($Laboratorio2 * 0.25) + ($Parcial * 0.50);

    return array(
        'Nombre' => $Nombre,
        'Laboratorio1' => $Laboratorio1,
        'Laboratorio2' => $Laboratorio2,
        'Parcial' => $Parcial,
        'Promedio' => $Promedio
    );
}

$server->service(file_get_contents("php://input"));
?>







