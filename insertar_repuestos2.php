<?php
include("conexionPDO.php");


$descripcion = $_POST["descripcion"];
$importe = $_POST["importe"];
$ganancia = $_POST["ganancia"];

$SentenciaSQL = "INSERT INTO repuestos (Descripcion, Importe, Ganancia) VALUES ('$descripcion', '$importe', '$ganancia')";


$result = $conexion->query($SentenciaSQL);
if ($result) {
    echo "Repuesto insertado correctamente";
} else {
    echo "Error al insertar el repuesto";
}

?>