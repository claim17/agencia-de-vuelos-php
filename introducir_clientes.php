<?php
include("seguridad.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introducir Clientes</title>
    <link rel="stylesheet" type="text/css" href="listar.css">
</head>
<body>
    <h1>Introducir Nuevo Cliente</h1>
    
    <form method="POST" action="introducir_clientes2.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" required>
        </div>

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="apellido1">Primer Apellido:</label>
            <input type="text" id="apellido1" name="apellido1" required>
        </div>

        <div class="form-group">
            <label for="apellido2">Segundo Apellido:</label>
            <input type="text" id="apellido2" name="apellido2">
        </div>

        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required>
        </div>

        <div class="form-group">
            <label for="cp">Código Postal:</label>
            <input type="text" id="cp" name="cp" required>
        </div>

        <div class="form-group">
            <label for="poblacion">Población:</label>
            <input type="text" id="poblacion" name="poblacion" required>
        </div>

        <div class="form-group">
            <label for="provincia">Provincia:</label>
            <input type="text" id="provincia" name="provincia" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="imagen">Imagen:</label>
            <input type="file" id="foto" name="foto">
        </div>

        <button type="submit">Guardar Cliente</button>
        <input type=reset value="Borrar datos">
    </form>
</body>
</html>