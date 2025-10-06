<?php
include("conexionPDO.php");
include("seguridad.php");

// Obtener datos del formulario
$matricula = $_POST["Matricula"];
$fecha_emision = $_POST["Fecha_Emision"];
$fecha_pago = $_POST["Fecha_Pago"];
$base_imponible = $_POST["Base_Imponible"];
$iva = $_POST["IVA"];
$mano_obra = $_POST["Mano_de_Obra"];
$precio_hora = $_POST["Precio_Hora"];

// Calcular total
// Base imponible + IVA
$total = $base_imponible + ($base_imponible * ($iva / 100));

// Generar un nuevo número de factura
$SentenciaSQL = "SELECT MAX(Numero_Factura) AS max_numero FROM factura";
$result = $conexion->query($SentenciaSQL);
$row = $result->fetch(PDO::FETCH_ASSOC);
$nuevo_numero = 1; // Valor predeterminado si no hay facturas

if ($row && $row['max_numero'] !== null) {
    $nuevo_numero = $row['max_numero'] + 1;
}

// Insertar en la base de datos con el nuevo número de factura
$SentenciaSQL = "INSERT INTO factura (Numero_Factura, Matricula, Fecha_Emision, Fecha_Pago, Base_Imponible, IVA, Mano_de_Obra, Precio_Hora, Total) 
                VALUES ('$nuevo_numero', '$matricula', '$fecha_emision', '$fecha_pago', '$base_imponible', '$iva', '$mano_obra', '$precio_hora', '$total')";

try {
    $result = $conexion->query($SentenciaSQL);
    if ($result) {
        echo "Factura insertada correctamente con número: " . $nuevo_numero;
        // Redirigir a la lista de facturas después de un breve retraso
        header("refresh:2;url=lista_facturas.php");
    } else {
        echo "Error al insertar la factura: " . print_r($conexion->errorInfo(), true);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>