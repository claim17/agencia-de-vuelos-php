<?php
include "conexionPDO.php";

$dni=$_POST["dni"];
$nombre=$_POST["nombre"];
$apellido1=$_POST["apellido1"];
$apellido2=$_POST["apellido2"];
$direccion=$_POST["direccion"];
$cp=$_POST["cp"];
$poblacion=$_POST["poblacion"];
$provincia=$_POST["provincia"];
$telefono=$_POST["telefono"];
$email=$_POST["email"];




if (isset($_FILES["foto"]) && $_FILES["foto"]["tmp_name"] != "") {

    $contenido_imagen = file_get_contents($_FILES["foto"]["tmp_name"]);

    $jpg = addslashes($contenido_imagen);

} else {

    $jpg = "";

}


$SentenciaSQL="INSERT INTO clientes (DNI,Nombre,Apellido1,Apellido2,Direccion,CP,Poblacion,Provincia,Telefono,Email,Fotografia) VALUES ('$dni','$nombre','$apellido1','$apellido2','$direccion','$cp','$poblacion','$provincia','$telefono','$email','$jpg')";

$result = $conexion->query($SentenciaSQL);

if ($result) {
    echo "Cliente insertado correctamente";
} else {
    echo "Error al insertar el cliente";
}


?>