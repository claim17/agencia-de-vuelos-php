<?php
include("conexionPDO.php");

//vamos a hacer el acyualizar barco
$matricula=$_POST["matricula"];
$longitud=$_POST["longitud"];
$potencia=$_POST["potencia"];
$motor=$_POST["motor"];
$anyo=$_POST["anyo"];
$color=$_POST["color"];
$material=$_POST["material"];

//esto creo que lo devemos dejar igual

if (isset($_FILES["foto"]) && $_FILES["foto"]["tmp_name"] != "") {
    $contenido_imagen = file_get_contents($_FILES["foto"]["tmp_name"]);
    $jpg = addslashes($contenido_imagen);
} else {
    $jpg = "";
}

$SentenciaSQL = "UPDATE embarcaciones SET Longitud='$longitud', Potencia='$potencia', Motor='$motor', Año='$anyo', Color='$color', Material='$material' WHERE Matricula='$matricula'$logfile = 'logs/embarcaciones.log';

if (isset($_FILES["foto"]) && $_FILES["foto"]["tmp_name"] != "") {
    $contenido_imagen = file_get_contents($_FILES["foto"]["tmp_name"]);
    $jpg = addslashes($contenido_imagen);
} else {
    $jpg = "";
}

$SentenciaSQL = "UPDATE embarcaciones SET Longitud='$longitud', Potencia='$potencia', Motor='$motor', Año='$anyo', Color='$color', Material='$material' WHERE Matricula='$matricula'";
try {
    $result = $conexion->query($SentenciaSQL);
    if ($result) {
        $log = date('Y-m-d H:i:s') . ' - Embarcación actualizada correctamente - Matricula: ' . $matricula . "\n";
        file_put_contents($logfile, $log, FILE_APPEND);
        echo "Cliente actualizado correctamente";
    } else {
        $log = date('Y-m-d H:i:s') . ' - Error al actualizar la embarcación - Matricula: ' . $matricula . "\n";
        file_put_contents($logfile, $log, FILE_APPEND);
        echo "Error al actualizar el cliente";
    }
} catch (PDOException $e) {
    $log = date('Y-m-d H:i:s') . ' - Error: ' . $e->getMessage() . "\n";
    file_put_contents($logfile, $log, FILE_APPEND);
    echo "Error: " . $e->getMessage();
}";
try {
    $result = $conexion->query($SentenciaSQL);
    if ($result) {
        echo "Cliente actualizado correctamente";
    } else {
        echo "Error al actualizar el cliente";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>