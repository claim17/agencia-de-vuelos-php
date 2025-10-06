<?php
include("conexionPDO.php");
include("seguridad.php");

// Get parameters
$id = $_GET["id"];
$numero_factura = $_GET["numero_factura"];

try {
    // First, get the line details to calculate the amount to subtract from invoice
    $sql = "SELECT l.*, r.Importe, r.Ganancia 
            FROM detalle_factura l 
            LEFT JOIN repuestos r ON l.Referencia = r.Referencia 
            WHERE l.Id_Det_Factura = '$id'";
    $result = $conexion->query($sql);
    $linea = $result->fetch(PDO::FETCH_ASSOC);
    
    if ($linea) {
        // Calculate the amount to subtract
        $precio_unitario = $linea['Importe'] + ($linea['Importe'] * ($linea['Ganancia'] / 100));
        $subtotal = $precio_unitario * $linea['Unidades'];
        
        // Delete the line
        $SentenciaSQL = "DELETE FROM detalle_factura WHERE Id_Det_Factura = '$id'";
        $result = $conexion->query($SentenciaSQL);
        
        if ($result) {
            // Update invoice base_imponible and total
            $sql = "SELECT Base_Imponible, IVA, Mano_de_Obra, Precio_Hora FROM factura WHERE Numero_Factura = '$numero_factura'";
            $result = $conexion->query($sql);
            $factura = $result->fetch();
            
            // Calculate new base_imponible (existing - deleted line total)
            $nueva_base = $factura["Base_Imponible"] - $subtotal;
            
            // Calculate labor cost
            $costo_mano_obra = $factura["Mano_de_Obra"] * $factura["Precio_Hora"];
            
            // Add labor cost to base_imponible
            $nueva_base += $costo_mano_obra;
            
            // Calculate new total with VAT
            $nuevo_total = $nueva_base + ($nueva_base * ($factura["IVA"] / 100));
            
            // Update invoice
            $SentenciaSQL = "UPDATE factura SET Base_Imponible = '$nueva_base', Total = '$nuevo_total' WHERE Numero_Factura = '$numero_factura'";
            $conexion->query($SentenciaSQL);
            
            echo "Línea de factura eliminada correctamente";
        } else {
            echo "Error al eliminar la línea de factura";
        }
    } else {
        echo "No se encontró la línea de factura";
    }
    
    // Redirect back to invoice details
    header("refresh:2;url=detalles_factura.php?numero_factura=" . $numero_factura);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    header("refresh:5;url=detalles_factura.php?numero_factura=" . $numero_factura);
}
?>