<?php
include("conexionPDO.php");
include("seguridad.php");

// Obtener datos del formulario
$numero_factura = $_POST["Numero_Factura"];
$matricula = $_POST["Matricula"];
$fecha_emision = $_POST["Fecha_Emision"];
$fecha_pago = $_POST["Fecha_Pago"];
$base_imponible = $_POST["Base_Imponible"];
$iva = $_POST["IVA"];
$mano_obra = $_POST["Mano_de_Obra"];
$precio_hora = $_POST["Precio_Hora"];

// Calcular total
$total = $base_imponible + ($base_imponible * ($iva / 100));

// Actualizar en la base de datos
$SentenciaSQL = "UPDATE factura SET 
                Matricula = '$matricula', 
                Fecha_Emision = '$fecha_emision', 
                Fecha_Pago = '$fecha_pago', 
                Base_Imponible = '$base_imponible', 
                IVA = '$iva', 
                Mano_de_Obra = '$mano_obra', 
                Precio_Hora = '$precio_hora', 
                Total = '$total' 
                WHERE Numero_Factura = '$numero_factura'";

try {
    $result = $conexion->query($SentenciaSQL);
    if ($result) {
        echo "Factura actualizada correctamente";
        // Redirigir a la lista de facturas después de un breve retraso
        header("refresh:2;url=lista_facturas.php");
    } else {
        echo "Error al actualizar la factura";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>