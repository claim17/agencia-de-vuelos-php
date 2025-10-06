<?php
include("conexionPDO.php");
include("seguridad.php");
include ("eliminar_temporales.php");

$sql = "SELECT e.*, c.Nombre, c.Apellido1, c.Apellido2 FROM embarcaciones e 
        LEFT JOIN clientes c ON e.Id_Cliente = c.Id_Cliente 
        ORDER BY e.Id_Cliente";
$result = $conexion->query($sql);
$rows = $result->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Embarcaciones</title>
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
        .checkbox-container {
            text-align: center;
        }
        .btn-submit {
            margin-top: 15px;
            padding: 8px 15px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Lista de Embarcaciones</h1>
    
    <form method='POST' action='borrar_barco.php'>
        <table>
            <tr>
                <th>Seleccionar</th>
                <th>ID Cliente</th>
                <th>Matrícula</th>
                <th>Longitud</th>
                <th>Potencia</th>
                <th>Motor</th>
                <th>Año</th>
                <th>Color</th>
                <th>Material</th>
                <th>Propietario</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
            
            <?php foreach ($rows as $row) { 
                $id_cliente = $row['Id_Cliente'];
                $matricula = $row['Matricula'];
                $longitud = $row['Longitud'];
                $potencia = $row['Potencia'];
                $motor = $row['Motor'];
                $anyo = isset($row['Año']) ? $row['Año'] : '';
                $color = $row['Color'];
                $material = $row['Material'];
                $nombre_cliente = isset($row['Nombre']) ? $row['Nombre'] . ' ' . $row['Apellido1'] . ' ' . $row['Apellido2'] : 'Sin propietario';
                
                // Check if 'Fotografia' key exists before accessing it
                $foto = isset($row['Fotografia']) ? $row['Fotografia'] : null;
                
                // Crear imagen temporal si existe
                if($foto) {
                    $imagen = basename(tempnam(getcwd() . "/temporales", "temp")) . ".jpg";
                    $fichero = fopen("temporales/" . $imagen, "w");
                    fwrite($fichero, $foto);
                    fclose($fichero);
                } else {
                    $imagen = "";
                }
            ?>
            <tr>
                <td class="checkbox-container"><input type='checkbox' name='borrarbar[]' value='<?php echo $matricula; ?>'></td>
                <td><?php echo $id_cliente; ?></td>
                <td><?php echo $matricula; ?></td>
                <td><?php echo $longitud; ?></td>
                <td><?php echo $potencia; ?></td>
                <td><?php echo $motor; ?></td>
                <td><?php echo $anyo; ?></td>
                <td><?php echo $color; ?></td>
                <td><?php echo $material; ?></td>
                <td><?php echo $nombre_cliente; ?></td>
                <td><?php if($imagen) { ?><img src='temporales/<?php echo $imagen; ?>' width='100' height='100'><?php } ?></td>
                <td class="acciones">
                    <a href='detalles_barco.php?matricula=<?php echo $matricula; ?>'>Detalles</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        
        <input type='submit' value='Eliminar Seleccionados' class="btn-submit" onclick="return confirm('¿Está seguro de que desea eliminar las embarcaciones seleccionadas?');">
    </form>
    
    <a href="introducir_barcos.php" style="display: inline-block; margin-top: 20px; padding: 10px 15px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 3px;">Añadir Nueva Embarcación</a>
</body>
</html>
