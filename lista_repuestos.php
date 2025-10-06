<?php
include("conexionPDO.php");
include("seguridad.php");

$sql = "SELECT * FROM repuestos ORDER BY Referencia";
$result = $conexion->query($sql);
$rows = $result->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Repuestos</title>
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
        img {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>
    <h1>Lista de Repuestos</h1>
    
    <table>
        <tr>
            <th>Referencia</th>
            <th>Descripción</th>
            <th>Importe</th>
            <th>Ganancia (%)</th>
            
            <th>Acciones</th>
        </tr>
        
        <?php foreach ($rows as $row) { 
            $referencia = $row['Referencia'];
            $descripcion = $row['Descripcion'];
            $importe = $row['Importe'];
            $ganancia = $row['Ganancia'];
            
        ?>
        <tr>
            <td><?php echo $referencia; ?></td>
            <td><?php echo $descripcion; ?></td>
            <td><?php echo number_format($importe, 2, ',', '.') . " €"; ?></td>
            <td><?php echo $ganancia . "%"; ?></td>
            <td class="acciones">
                <a href='detalles_repuesto.php?referencia=<?php echo $referencia; ?>'>Detalles</a>
                <a href='borrar_repuesto.php?referencia=<?php echo $referencia; ?>' class="eliminar" onclick="return confirm('¿Está seguro de que desea eliminar este repuesto?');">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    
    <a href="introducir_repuestos.php" style="display: inline-block; margin-top: 20px; padding: 10px 15px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 3px;">Añadir Nuevo Repuesto</a>
</body>
</html>
