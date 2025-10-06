<?php
include("conexionPDO.php");

$id_cliente = $_POST["id_cliente"];
$dni = $_POST["dni"];
$nombre = $_POST["nombre"];
$apellido1 = $_POST["apellido1"];
$apellido2 = $_POST["apellido2"];
$direccion = $_POST["direccion"];
$cp = $_POST["cp"];
$poblacion = $_POST["poblacion"];
$provincia = $_POST["provincia"];
$telefono = $_POST["telefono"];
$email = $_POST["email"];


if (isset($_FILES["foto"]) && $_FILES["foto"]["tmp_name"] != "") {
    $contenido_imagen = file_get_contents($_FILES["foto"]["tmp_name"]);
    $jpg = addslashes($contenido_imagen);
} else {
    $jpg = "";
}

$SentenciaSQL = "UPDATE clientes SET DNI = '$dni', Nombre = '$nombre', Apellido1 = '$apellido1', Apellido2 = '$apellido2', Direccion = '$direccion', CP = '$cp', Poblacion = '$poblacion', Provincia = '$provincia', Telefono = '$telefono', Email = '$email', Fotografia = '$jpg' WHERE id_cliente = '$id_cliente'";

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