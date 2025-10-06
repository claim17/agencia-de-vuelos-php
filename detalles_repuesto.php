<?php
include("conexionPDO.php");
include("seguridad.php");

$referencia = $_GET["referencia"];

// Check if form was submitted for updating
if(isset($_POST['actualizar'])) {
    $descripcion = $_POST['descripcion'];
    $importe = $_POST['importe'];
    $ganancia = $_POST['ganancia'];
    
    $sql_update = "UPDATE repuestos SET Descripcion = '$descripcion', Importe = '$importe', Ganancia = '$ganancia' WHERE Referencia = '$referencia'";
    
    $result_update = $conexion->query($sql_update);
    
    if($result_update) {
        echo "<script>alert('Repuesto actualizado correctamente');</script>";
    } else {
        echo "<script>alert('Error al actualizar el repuesto');</script>";
    }
}

$sql = "SELECT * FROM repuestos WHERE Referencia = '$referencia'";
$result = $conexion->query($sql);
$row = $result->fetch();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Repuesto</title>
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
        textarea {
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
        <h1>Editar Repuesto</h1>
        
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Referencia:</label>
                <input type="text" value="<?php echo $row['Referencia']; ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" required><?php echo $row['Descripcion']; ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="importe">Importe (€):</label>
                <input type="number" id="importe" name="importe" value="<?php echo $row['Importe']; ?>" step="0.01" required>
            </div>
            
            <div class="form-group">
                <label for="ganancia">Ganancia (%):</label>
                <input type="number" id="ganancia" name="ganancia" value="<?php echo $row['Ganancia']; ?>" required>
            </div>
            
            <div class="buttons">
                <button type="submit" name="actualizar" class="btn">Guardar Cambios</button>
                <a href="lista_repuestos.php" class="btn" style="background-color: #7f8c8d;">Cancelar</a>
                <a href="borrar_repuesto.php?referencia=<?php echo $referencia; ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar este repuesto?');">Eliminar</a>
            </div>
        </form>
    </div>
</body>
</html>