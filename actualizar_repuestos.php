<?php
include("conexionPDO.php");

$Referencia = $_POST["Referencia"];
$descripcion = $_POST["Descripcion"];
$importe = $_POST["Importe"];
$ganancia = $_POST["Ganancia"];

$SentenciaSQL = "UPDATE repuestos SET Descripcion = '$descripcion', Importe = '$importe', Ganancia = '$ganancia' WHERE Referencia = '$Referencia'";

try {
    $result = $conexion->query($SentenciaSQL);
    if ($result) {
        echo "Repuesto actualizado correctamente";
    } else {
        echo "Error al actualizar el repuesto";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>