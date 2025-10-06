<?php
include("conexionPDO.php");
include("seguridad.php");
include ("eliminar_temporales.php");

$id_cliente = $_GET["id_cliente"];

// Check if form was submitted for updating
if(isset($_POST['actualizar'])) {
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $direccion = $_POST['direccion'];
    $cp = $_POST['cp'];
    $poblacion = $_POST['poblacion'];
    $provincia = $_POST['provincia'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    
    // Process image if a new one was uploaded
    if(isset($_FILES["foto"]) && $_FILES["foto"]["tmp_name"] != "") {
        $contenido_imagen = file_get_contents($_FILES["foto"]["tmp_name"]);
        $jpg = addslashes($contenido_imagen);
        $sql_update = "UPDATE clientes SET 
                      DNI = '$dni', 
                      Nombre = '$nombre', 
                      Apellido1 = '$apellido1', 
                      Apellido2 = '$apellido2', 
                      Direccion = '$direccion', 
                      CP = '$cp',
                      Poblacion = '$poblacion',
                      Provincia = '$provincia',
                      Telefono = '$telefono',
                      Email = '$email',
                      Fotografia = '$jpg'
                      WHERE Id_Cliente = '$id_cliente'";
    } else {
        $sql_update = "UPDATE clientes SET 
                      DNI = '$dni', 
                      Nombre = '$nombre', 
                      Apellido1 = '$apellido1', 
                      Apellido2 = '$apellido2', 
                      Direccion = '$direccion', 
                      CP = '$cp',
                      Poblacion = '$poblacion',
                      Provincia = '$provincia',
                      Telefono = '$telefono',
                      Email = '$email'
                      WHERE Id_Cliente = '$id_cliente'";
    }
    
    $result_update = $conexion->query($sql_update);
    
    if($result_update) {
        echo "<script>alert('Cliente actualizado correctamente');</script>";
    } else {
        echo "<script>alert('Error al actualizar el cliente');</script>";
    }
}

$sql = "SELECT * FROM clientes WHERE Id_Cliente = '$id_cliente'";
$result = $conexion->query($sql);
$row = $result->fetch();

// Crear imagen temporal si existe
$foto = isset($row['Fotografia']) ? $row['Fotografia'] : null;
if($foto) {
    $imagen = basename(tempnam(getcwd() . "/temporales", "temp")) . ".jpg";
    $fichero = fopen("temporales/" . $imagen, "w");
    fwrite($fichero, $foto);
    fclose($fichero);
} else {
    $imagen = "";
}

// Obtener las embarcaciones del cliente
$sql_barcos = "SELECT * FROM embarcaciones WHERE Id_Cliente = '$id_cliente'";
$result_barcos = $conexion->query($sql_barcos);
$barcos = $result_barcos->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .current-image {
            margin: 10px 0;
        }
        img {
            max-width: 300px;
            max-height: 300px;
            border: 1px solid #ddd;
            padding: 5px;
        }
        .buttons {
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            margin-right: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            border: none;
            cursor: pointer;
        }
        .btn-danger {
            background-color: #f44336;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Cliente</h1>
        
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>ID Cliente:</label>
                <input type="text" value="<?php echo $row['Id_Cliente']; ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni" value="<?php echo $row['DNI']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $row['Nombre']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="apellido1">Primer Apellido:</label>
                <input type="text" id="apellido1" name="apellido1" value="<?php echo $row['Apellido1']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="apellido2">Segundo Apellido:</label>
                <input type="text" id="apellido2" name="apellido2" value="<?php echo $row['Apellido2']; ?>">
            </div>
            
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo $row['Direccion']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="cp">Código Postal:</label>
                <input type="text" id="cp" name="cp" value="<?php echo $row['CP']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="poblacion">Población:</label>
                <input type="text" id="poblacion" name="poblacion" value="<?php echo $row['Poblacion']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="provincia">Provincia:</label>
                <input type="text" id="provincia" name="provincia" value="<?php echo $row['Provincia']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo $row['Telefono']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $row['Email']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="foto">Fotografía:</label>
                <input type="file" id="foto" name="foto">
                <?php if($imagen): ?>
                <div class="current-image">
                    <p>Imagen actual:</p>
                    <img src="temporales/<?php echo $imagen; ?>" alt="Fotografía del cliente">
                </div>
                <?php endif; ?>
            </div>
            
            <div class="buttons">
                <button type="submit" name="actualizar" class="btn">Guardar Cambios</button>
                <a href="listar.php" class="btn" style="background-color: #7f8c8d;">Cancelar</a>
                <a href="borrar_cliente_individual.php?id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar este cliente?');">Eliminar</a>
            </div>
        </form>
        
        <?php if(count($barcos) > 0): ?>
        <h2>Embarcaciones del Cliente</h2>
        <table>
            <tr>
                <th>Matrícula</th>
                <th>Longitud</th>
                <th>Potencia</th>
                <th>Motor</th>
                <th>Acciones</th>
            </tr>
            <?php foreach($barcos as $barco): ?>
            <tr>
                <td><?php echo $barco['Matricula']; ?></td>
                <td><?php echo $barco['Longitud']; ?> metros</td>
                <td><?php echo $barco['Potencia']; ?> CV</td>
                <td><?php echo $barco['Motor']; ?></td>
                <td>
                    <a href="detalles_barco.php?matricula=<?php echo $barco['Matricula']; ?>" class="btn">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</body>
</html>

