<?php
include("conexionPDO.php");
include("seguridad.php");

$id_cliente = $_GET["id_cliente"];

// Eliminar el cliente
$SentenciaSQL = "DELETE FROM clientes WHERE Id_Cliente = '$id_cliente'";
$resultado = $conexion->query($SentenciaSQL);

if ($resultado) {
    echo "<script>
            alert('Cliente eliminado correctamente');
            window.location.href = 'listar.php';
          </script>";
} else {
    echo "<script>
            alert('Error al eliminar el cliente. Puede que tenga embarcaciones asociadas.');
            window.location.href = 'listar.php';
          </script>";
}
?>