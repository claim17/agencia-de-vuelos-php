<?php
include("conexionPDO.php");
include("seguridad.php");

// Standardize parameter name
$numero_factura = isset($_GET["numero_factura"]) ? $_GET["numero_factura"] : $_GET["Numero_Factura"];

try {
    // Check if detalle_factura table exists
    $check_table = $conexion->query("SHOW TABLES LIKE 'detalle_factura'");
    $table_exists = ($check_table->rowCount() > 0);
    
    // Only try to delete from detalle_factura if the table exists
    if ($table_exists) {
        // First delete all related invoice lines
        $SentenciaSQL = "DELETE FROM detalle_factura WHERE Numero_Factura = '$numero_factura'";
        $conexion->query($SentenciaSQL);
    }
    
    // Then delete the invoice
    $SentenciaSQL = "DELETE FROM factura WHERE Numero_Factura = '$numero_factura'";
    $result = $conexion->query($SentenciaSQL);
    
    if ($result) {
        echo "Factura eliminada correctamente";
        // Redirect to invoice list after a brief delay
        header("refresh:2;url=lista_facturas.php");
    } else {
        echo "Error al eliminar la factura";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>