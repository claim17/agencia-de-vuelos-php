<?php
include("conexionPDO.php");
include("seguridad.php");

$matricula = $_POST["matricula"];
$longitud = $_POST["longitud"];
$potencia = $_POST["potencia"];
$motor = $_POST["motor"];
$anyo = $_POST["anyo"];
$color = $_POST["color"];
$material = $_POST["material"];
$id_cliente = $_POST["id_cliente"]; // Asegurarse de que este campo se está recibiendo correctamente

// Procesar la imagen si se ha subido
if (isset($_FILES["foto"]) && $_FILES["foto"]["tmp_name"] != "") {
    $contenido_imagen = file_get_contents($_FILES["foto"]["tmp_name"]);
    $jpg = addslashes($contenido_imagen);
} else {
    $jpg = "";
}

// Asegurarse de que la consulta SQL incluye el id_cliente
$SentenciaSQL = "INSERT INTO embarcaciones (Matricula, Longitud, Potencia, Motor, Año, Color, Material, Fotografia, Id_Cliente) 
                VALUES ('$matricula', '$longitud', '$potencia', '$motor', '$anyo', '$color', '$material', '$jpg', '$id_cliente')";

$result = $conexion->query($SentenciaSQL);

if ($result) {
    echo "Embarcación insertada correctamente";
    // Redirigir a la lista de embarcaciones después de un breve retraso
    header("refresh:2;url=lista_barcos.php");
} else {
    echo "Error al insertar la embarcación";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Inserción</title>
    <link rel="stylesheet" type="text/css" href="estilos_mejorados.css">
</head>
<body>
    <div class="container">
        <div class="resultado-box <?php echo $result ? 'exito' : 'error'; ?>">
            <h2><?php echo $result ? '¡Embarcación Registrada!' : 'Error en el Registro'; ?></h2>
            <p>
                <?php if($result): ?>
                    La embarcación con matrícula <strong><?php echo $matricula; ?></strong> ha sido insertada correctamente en la base de datos.
                <?php else: ?>
                    Ha ocurrido un error al intentar registrar la embarcación. Por favor, inténtelo de nuevo.
                <?php endif; ?>
            </p>
            <div class="botones">
                <a href="lista_barcos.php" class="btn btn-primary">Ver Lista de Embarcaciones</a>
                <a href="introducir_barcos.php" class="btn btn-secondary">Registrar Otra Embarcación</a>
            </div>
        </div>
    </div>
    
    <script>
        // Redirección automática después de 3 segundos si fue exitoso
        <?php if($result): ?>
        setTimeout(function() {
            window.location.href = 'lista_barcos.php';
        }, 3000);
        <?php endif; ?>
    </script>
</body>
</html>