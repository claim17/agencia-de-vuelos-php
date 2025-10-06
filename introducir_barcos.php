<?php
include("seguridad.php");

//quiero que al introducir un barco este tenga que elegir un id de cliente existente en la base de datos
include("conexionPDO.php");
// $sql = "SELECT * FROM clientes order by id_cliente";
$sql = "SELECT * FROM clientes";
$result = $conexion->query($sql);
$rows = $result->fetchAll();
// $rows = $result->fetchAll(PDO::FETCH_ASSOC);

?>
 
 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introducir Barcos</title>
    <link rel="stylesheet" type="text/css" href="listar.css">
</head>
<body>
    <h1>Introducir Nuevo Barco</h1>

        <!-- la logitud la introducimos como float , la potencia como int  , año como int  y foto en blob    -->

    <form method="POST" action="introducir_barcos2.php" enctype="multipart/form-data">
       
        <div class="form-group">
            <label for="matricula">Matricula:</label>
            <input type="text" id="matricula" name="matricula" required>
        </div>

        <div class="form-group">
            <label for="longitud">Longitud:</label>
            <input type="text" id="longitud" name="longitud" required>
        </div>

        <div class="form-group">
            <label for="potencia">Potencia:</label>
            <input type="text" id="potencia" name="potencia" required>
        </div>

        <div class="form-group">
            <label for="motor">Motor:</label>
            <input type="text" id="motor" name="motor" required>
        </div>

        <div class="form-group">
            <label for="anyo">Año:</label>
            <input type="text" id="anyo" name="anyo" required>
        </div>

        <div class = "form-group">
            <label for="color">Color:</label>
            <input type="text" id="color" name="color" required>
        </div>

        <div class="form-group">
            <label for="material">Material:</label>
            <input type="text" id="material" name="material" required>
        </div>
        
        <div class="form-group">
            <label for="imagen">Imagen:</label>
            <input type="file" id="foto" name="foto" >
        </div>
        <div class="form-group">
            <label for="id_cliente">ID Cliente:</label>
            <select id="id_cliente" name="id_cliente" required>
                <?php
                foreach ($rows as $row) {
                    $id_cliente = $row['Id_Cliente'];
                    echo "<option value='$id_cliente'>$id_cliente</option>";
                }
                ?>
            </select>
        </div>
        

        <button type="submit">Guardar Barco</button>
        <input type=reset value="Borrar datos">
    </form>
</body>
</html>