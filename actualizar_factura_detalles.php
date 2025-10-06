<?php
include("conexionPDO.php");
include("seguridad.php");

// Check if form was submitted
if(isset($_POST['actualizar'])) {
    // Get form data
    $numero_factura = $_POST["numero_factura"];
    $matricula = $_POST["matricula"];
    $fecha_emision = $_POST["fecha_emision"];
    $fecha_pago = $_POST["fecha_pago"];
    $base_imponible = $_POST["base_imponible"];
    $iva = $_POST["iva"];
    $mano_obra = $_POST["mano_de_obra"] ?? 0;
    $precio_hora = $_POST["precio_hora"] ?? 0;
    
    // Calculate labor cost
    $costo_mano_obra = $mano_obra * $precio_hora;
    
    // Add labor cost to base_imponible for total calculation
    $nueva_base = $base_imponible + $costo_mano_obra;
    
    // Calculate total with VAT
    $total = $nueva_base + ($nueva_base * ($iva / 100));
    
    // Update database
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
            echo "<script>alert('Factura actualizada correctamente'); window.location.href='detalles_factura.php?numero_factura=$numero_factura';</script>";
        } else {
            echo "<script>alert('Error al actualizar la factura'); window.location.href='detalles_factura.php?numero_factura=$numero_factura';</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='detalles_factura.php?numero_factura=$numero_factura';</script>";
    }
} else {
    // Redirect if accessed directly
    header("Location: lista_facturas.php");
}
?>