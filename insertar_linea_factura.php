<?php
include("conexionPDO.php");
include("seguridad.php");

// Get form data
$numero_factura = $_POST["Numero_Factura"];
$referencia = $_POST["Referencia"];
$unidades = $_POST["Unidades"];

// Get part details to calculate price
$sql = "SELECT Importe, Ganancia FROM repuestos WHERE Referencia = '$referencia'";
$result = $conexion->query($sql);
$repuesto = $result->fetch();

$importe = $repuesto["Importe"];
$ganancia = $repuesto["Ganancia"];

// Calculate line total with profit margin
$precio_linea = $importe + ($importe * ($ganancia / 100));
$total_linea = $precio_linea * $unidades;

// Insert into database - Using only the columns that exist in the table
$SentenciaSQL = "INSERT INTO detalle_factura (Numero_Factura, Referencia, Unidades) 
                VALUES ('$numero_factura', '$referencia', '$unidades')";

try {
    $result = $conexion->query($SentenciaSQL);
    
    if ($result) {
        // Update invoice base_imponible and total
        $sql = "SELECT Base_Imponible, IVA, Mano_de_Obra, Precio_Hora FROM factura WHERE Numero_Factura = '$numero_factura'";
        $result = $conexion->query($sql);
        $factura = $result->fetch();
        
        // Calculate new base_imponible (existing + new line total)
        $nueva_base = $factura["Base_Imponible"] + $total_linea;
        
        // Calculate labor cost
        $costo_mano_obra = $factura["Mano_de_Obra"] * $factura["Precio_Hora"];
        
        // Add labor cost to base_imponible
        $nueva_base += $costo_mano_obra;
        
        // Calculate new total with VAT
        $nuevo_total = $nueva_base + ($nueva_base * ($factura["IVA"] / 100));
        
        // Update invoice
        $SentenciaSQL = "UPDATE factura SET Base_Imponible = '$nueva_base', Total = '$nuevo_total' WHERE Numero_Factura = '$numero_factura'";
        $result = $conexion->query($SentenciaSQL);
        
        echo "Línea de factura insertada correctamente";
        // Redirect to invoice details after a brief delay
        header("refresh:2;url=detalles_factura.php?numero_factura=" . $numero_factura);
    } else {
        echo "Error al insertar la línea de factura";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>