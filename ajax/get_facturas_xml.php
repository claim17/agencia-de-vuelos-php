<?php
include("../conexionPDO.php");

ob_clean();
header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<facturas>';

$matricula = $_POST['matricula'];

try {
    $sql = "SELECT * FROM factura WHERE Matricula = ? ORDER BY Fecha_Emision DESC";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$matricula]);
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<factura>';
        echo '<numero>' . htmlspecialchars($row['Numero_Factura'], ENT_XML1, 'UTF-8') . '</numero>';
        echo '<fecha>' . htmlspecialchars($row['Fecha_Emision'], ENT_XML1, 'UTF-8') . '</fecha>';
        echo '<base>' . number_format($row['Base_Imponible'], 2, ',', '.') . '</base>';
        echo '<iva>' . htmlspecialchars($row['IVA'], ENT_XML1, 'UTF-8') . '</iva>';
        echo '<total>' . number_format($row['Total'], 2, ',', '.') . '</total>';
        echo '</factura>';
    }
} catch (PDOException $e) {
    error_log("Error en la consulta: " . $e->getMessage());
    echo '<error>' . htmlspecialchars($e->getMessage(), ENT_XML1, 'UTF-8') . '</error>';
}

echo '</facturas>';
?>