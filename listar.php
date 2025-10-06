<?php
include("conexionPDO.php");
include("seguridad.php");
include ("eliminar_temporales.php");

$sql = "SELECT * FROM clientes order by id_cliente";
$result = $conexion->query($sql);
$rows = $result->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" type="text/css" href="listar.css">
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
    <h1>Lista de Clientes</h1>
    
    <table>
        <tr>
            <th>ID</th>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Dirección</th>
            <th>CP</th>
            <th>Población</th>
            <th>Provincia</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Foto</th>
            <th>Acciones</th>
        </tr>
        
        <?php foreach ($rows as $row) { 
            $id_cliente = $row['Id_Cliente'];
            $dni = $row['DNI'];
            $nombre = $row['Nombre'];
            $apellido1 = $row['Apellido1'];
            $apellido2 = $row['Apellido2'];
            $direccion = $row['Direccion'];
            $cp = $row['CP'];
            $poblacion = $row['Poblacion'];
            $provincia = $row['Provincia'];
            $telefono = $row['Telefono'];
            $email = $row['Email'];
            $foto = $row['Fotografia'];
            
            // Crear imagen temporal
            $imagen = basename(tempnam(getcwd() . "/temporales", "temp")) . ".jpg";
            $fichero = fopen("temporales/" . $imagen, "w");
            fwrite($fichero, $foto);
            fclose($fichero);
        ?>
        <tr>
            <td><?php echo $id_cliente; ?></td>
            <td><?php echo $dni; ?></td>
            <td><?php echo $nombre; ?></td>
            <td><?php echo $apellido1 . " " . $apellido2; ?></td>
            <td><?php echo $direccion; ?></td>
            <td><?php echo $cp; ?></td>
            <td><?php echo $poblacion; ?></td>
            <td><?php echo $provincia; ?></td>
            <td><?php echo $telefono; ?></td>
            <td><?php echo $email; ?></td>
            <td><img src='temporales/<?php echo $imagen; ?>' width='100' height='100'></td>
            <td class="acciones">
                <a href='detalles_cliente.php?id_cliente=<?php echo $id_cliente; ?>'>Detalles</a>
                <a href='borrar_cliente_individual.php?id_cliente=<?php echo $id_cliente; ?>' class="eliminar" onclick="return confirm('¿Está seguro de que desea eliminar este cliente?');">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    
    <h2>Eliminar Múltiples Clientes</h2>
    <form method='POST' action='borrar_cliente.php'>
        <table>
            <tr>
                <th>Seleccionar</th>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
            </tr>
            
            <?php 
            // Reset the result set
            $result = $conexion->query($sql);
            $rows = $result->fetchAll();
            
            foreach ($rows as $row) { 
                $id_cliente = $row['Id_Cliente'];
                $nombre = $row['Nombre'];
                $apellido1 = $row['Apellido1'];
                $apellido2 = $row['Apellido2'];
            ?>
            <tr>
                <td><input type='checkbox' name='borrar[]' value='<?php echo $id_cliente; ?>'></td>
                <td><?php echo $id_cliente; ?></td>
                <td><?php echo $nombre; ?></td>
                <td><?php echo $apellido1 . " " . $apellido2; ?></td>
            </tr>
            <?php } ?>
        </table>
        
        <input type='submit' value='Eliminar Seleccionados' onclick="return confirm('¿Está seguro de que desea eliminar los clientes seleccionados?');">
    </form>
</body>
</html>
