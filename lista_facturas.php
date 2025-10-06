<?php
include("conexionPDO.php");
include("seguridad.php");

$sql = "SELECT f.*, e.Matricula, c.Nombre, c.Apellido1, c.Apellido2 
        FROM factura f 
        LEFT JOIN embarcaciones e ON f.Matricula = e.Matricula 
        LEFT JOIN clientes c ON e.Id_Cliente = c.Id_Cliente 
        ORDER BY f.Numero_Factura DESC";
$result = $conexion->query($sql);
$rows = $result->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Facturas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .acciones a {
            display: inline-block;
            margin-right: 5px;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }
        .acciones a.eliminar {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <h1>Lista de Facturas</h1>
    <a href="ajax/buscador_facturas.php" class="btn">Buscador AJAX de Facturas</a>
    <table>
        <tr>
            <th>Número</th>
            <th>Fecha Emisión</th>
            <th>Fecha Pago</th>
            <th>Matrícula</th>
            <th>Cliente</th>
            <th>Base Imponible</th>
            <th>IVA</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
        
        <?php foreach ($rows as $row) { 
            $numero_factura = $row['Numero_Factura'];
            $fecha_emision = $row['Fecha_Emision'];
            $fecha_pago = $row['Fecha_Pago'];
            $matricula = $row['Matricula'];
            $base_imponible = $row['Base_Imponible'];
            $iva = $row['IVA'];
            $total = $row['Total'];
            $nombre_cliente = $row['Nombre'] . ' ' . $row['Apellido1'] . ' ' . $row['Apellido2'];
        ?>
        <tr>
            <td><?php echo $numero_factura; ?></td>
            <td><?php echo $fecha_emision; ?></td>
            <td><?php echo $fecha_pago; ?></td>
            <td><?php echo $matricula; ?></td>
            <td><?php echo $nombre_cliente; ?></td>
            <td><?php echo number_format($base_imponible, 2, ',', '.') . " €"; ?></td>
            <td><?php echo $iva . "%"; ?></td>
            <td><?php echo number_format($total, 2, ',', '.') . " €"; ?></td>
            <td class="acciones">
                <a href='detalles_factura.php?numero_factura=<?php echo $numero_factura; ?>'>Detalles</a>
                <a href='borrar_factura.php?numero_factura=<?php echo $numero_factura; ?>' class="eliminar" onclick="return confirm('¿Está seguro de que desea eliminar esta factura?');">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    
    <a href="introducir_factura.php" style="display: inline-block; margin-top: 20px; padding: 10px 15px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 3px;">Añadir Nueva Factura</a>
</body>
</html>