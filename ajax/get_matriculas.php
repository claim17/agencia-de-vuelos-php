<?php
include("../conexionPDO.php");

// Clear any previous output
ob_clean();

header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<matriculas>';

$dni = $_POST['dni'];

// Debug log
error_log("DNI recibido: " . $dni);

$sql = "SELECT DISTINCT e.Matricula 
        FROM embarcaciones e 
        INNER JOIN clientes c ON e.Id_Cliente = c.Id_Cliente 
        WHERE c.DNI = ?
        ORDER BY e.Matricula";

try {
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$dni]);
    
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Número de resultados: " . count($resultados));
    
    foreach($resultados as $row) {
        echo '<matricula>' . htmlspecialchars($row['Matricula'], ENT_XML1, 'UTF-8') . '</matricula>';
    }
} catch (PDOException $e) {
    error_log("Error en la consulta: " . $e->getMessage());
    echo '<error>' . htmlspecialchars($e->getMessage(), ENT_XML1, 'UTF-8') . '</error>';
}

echo '</matriculas>';
?>