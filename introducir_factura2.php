<?php
include("conexionPDO.php");

$Matricula = $_POST["Matricula"];
$Fecha_Emision = $_POST["Fecha_Emision"];
$Fecha_Pago = $_POST["Fecha_Pago"];
$Base_Imponible = $_POST["Base_Imponible"];
$IVA = $_POST["IVA"];
$Mano_de_Obra = $_POST["Mano_de_Obra"];
$Precio_Hora = $_POST["Precio_Hora"];
$Total = $_POST["Total"];

$SentenciaSQL = "SELECT MAX(Numero_Factura) AS maximo FROM factura";
$result = $conexion->query($SentenciaSQL);
$row = $result->fetch();
$Numero_Factura = $row["maximo"] + 1;

$SentenciaSQL = "INSERT INTO factura (Numero_Factura, Matricula, Fecha_Emision, Fecha_Pago, Base_Imponible, IVA, Mano_de_Obra, Precio_Hora, Total) VALUES ('$Numero_Factura', '$Matricula', '$Fecha_Emision', '$Fecha_Pago', '$Base_Imponible', '$IVA', '$Mano_de_Obra', '$Precio_Hora', '$Total')";

try {
    $result = $conexion->query($SentenciaSQL);
    if ($result) {
        echo "Factura insertada correctamente";
    } else {
        echo "Error al insertar la factura";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>