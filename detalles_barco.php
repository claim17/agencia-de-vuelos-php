<?php
include("conexionPDO.php");
include("seguridad.php");
include ("eliminar_temporales.php");

$matricula = $_GET["matricula"];

// Check if form was submitted for updating
if(isset($_POST['actualizar'])) {
    $longitud = $_POST['longitud'];
    $potencia = $_POST['potencia'];
    $motor = $_POST['motor'];
    $anyo = $_POST['anyo'];
    $color = $_POST['color'];
    $material = $_POST['material'];
    $id_cliente = $_POST['id_cliente'];
    
    // Process image if a new one was uploaded
    if(isset($_FILES["foto"]) && $_FILES["foto"]["tmp_name"] != "") {
        $contenido_imagen = file_get_contents($_FILES["foto"]["tmp_name"]);
        $jpg = addslashes($contenido_imagen);
        $sql_update = "UPDATE embarcaciones SET 
                      Longitud = '$longitud', 
                      Potencia = '$potencia', 
                      Motor = '$motor', 
                      Año = '$anyo', 
                      Color = '$color', 
                      Material = '$material', 
                      Id_Cliente = '$id_cliente',
                      Fotografia = '$jpg'
                      WHERE Matricula = '$matricula'";
    } else {
        $sql_update = "UPDATE embarcaciones SET 
                      Longitud = '$longitud', 
                      Potencia = '$potencia', 
                      Motor = '$motor', 
                      Año = '$anyo', 
                      Color = '$color', 
                      Material = '$material', 
                      Id_Cliente = '$id_cliente'
                      WHERE Matricula = '$matricula'";
    }
    
    $result_update = $conexion->query($sql_update);
    
    if($result_update) {
        echo "<script>alert('Embarcación actualizada correctamente');</script>";
    } else {
        echo "<script>alert('Error al actualizar la embarcación');</script>";
    }
}

$sql = "SELECT e.*, c.Nombre, c.Apellido1, c.Apellido2 FROM embarcaciones e 
        LEFT JOIN clientes c ON e.Id_Cliente = c.Id_Cliente 
        WHERE e.Matricula = '$matricula'";
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

// Get all clients for the dropdown
$sql_clientes = "SELECT Id_Cliente, Nombre, Apellido1, Apellido2 FROM clientes ORDER BY Nombre";
$result_clientes = $conexion->query($sql_clientes);
$clientes = $result_clientes->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Embarcación</title>
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
        h1 {
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
        input[type="number"],
        select {
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Embarcación</h1>
        
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Matrícula:</label>
                <input type="text" value="<?php echo $row['Matricula']; ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="longitud">Longitud (metros):</label>
                <input type="number" id="longitud" name="longitud" value="<?php echo $row['Longitud']; ?>" step="0.01" required>
            </div>
            
            <div class="form-group">
                <label for="potencia">Potencia (CV):</label>
                <input type="number" id="potencia" name="potencia" value="<?php echo $row['Potencia']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="motor">Motor:</label>
                <input type="text" id="motor" name="motor" value="<?php echo $row['Motor']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="anyo">Año:</label>
                <input type="number" id="anyo" name="anyo" value="<?php echo isset($row['Año']) ? $row['Año'] : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="color">Color:</label>
                <input type="text" id="color" name="color" value="<?php echo $row['Color']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="material">Material:</label>
                <input type="text" id="material" name="material" value="<?php echo $row['Material']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="id_cliente">Propietario:</label>
                <select id="id_cliente" name="id_cliente" required>
                    <option value="">Seleccione un propietario</option>
                    <?php foreach($clientes as $cliente): ?>
                    <option value="<?php echo $cliente['Id_Cliente']; ?>" <?php if($cliente['Id_Cliente'] == $row['Id_Cliente']) echo 'selected'; ?>>
                        <?php echo $cliente['Nombre'] . ' ' . $cliente['Apellido1'] . ' ' . $cliente['Apellido2']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="foto">Fotografía:</label>
                <input type="file" id="foto" name="foto">
                <?php if($imagen): ?>
                <div class="current-image">
                    <p>Imagen actual:</p>
                    <img src="temporales/<?php echo $imagen; ?>" alt="Fotografía de la embarcación">
                </div>
                <?php endif; ?>
            </div>
            
            <div class="buttons">
                <button type="submit" name="actualizar" class="btn">Guardar Cambios</button>
                <a href="listar_barcos.php" class="btn" style="background-color: #7f8c8d;">Cancelar</a>
                <a href="borrar_barco.php?matricula=<?php echo $matricula; ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar esta embarcación?');">Eliminar</a>
            </div>
        </form>
    </div>
</body>
</html>