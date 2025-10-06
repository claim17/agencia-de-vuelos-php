<?php
include("conexionPDO.php");
include("seguridad.php");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Factura</title>
    <link rel="stylesheet" type="text/css" href="listar.css">
</head>
<body>
    <h1>Insertar Factura</h1>

    <form method="POST" action="insertar_factura.php">

        <div class="form-group">
            <label for="Matricula">Matrícula:</label>
            <select name="Matricula">
                <?php
                $SentenciaSQL = "SELECT Matricula FROM embarcaciones";
                $result = $conexion->query($SentenciaSQL);
                $embarcaciones = $result->fetchAll();

                foreach ($embarcaciones as $embarcacion) { ?>
                    <option value="<?php echo $embarcacion["Matricula"]; ?>"><?php echo $embarcacion["Matricula"]; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="Fecha_Emision">Fecha de Emisión:</label>
            <input type="date" id="Fecha_Emision" name="Fecha_Emision">
        </div>

        <div class="form-group">
            <label for="Fecha_Pago">Fecha de Pago:</label>
            <input type="date" id="Fecha_Pago" name="Fecha_Pago">
        </div>

        <div class="form-group">
            <label for="Base_Imponible">Base Imponible:</label>
            <input type="number" id="Base_Imponible" name="Base_Imponible">
        </div>

        <div class="form-group">
            <label for="IVA">IVA:</label>
            <input type="number" id="IVA" name="IVA">
        </div>

        <div class="form-group">
            <label for="Mano_de_Obra">Mano de Obra:</label>
            <input type="number" id="Mano_de_Obra" name="Mano_de_Obra">
        </div>

        <div class="form-group">
            <label for="Precio_Hora">Precio Hora:</label>
            <input type="number" id="Precio_Hora" name="Precio_Hora">
        </div>

        <div class="form-group">
            <label for="Total">Total:</label>
            <input type="number" id="Total" name="Total">
        </div>

        <button type="submit">Guardar Factura</button>
        <input type=reset value="Borrar datos">
    </form>

    <h2>Introducir Líneas de Factura</h2>

    <form method="POST" action="insertar_linea_factura.php">

        <div class="form-group">
            <label for="Numero_Factura">Número de Factura:</label>
            <select name="Numero_Factura">
                <?php
                $SentenciaSQL = "SELECT Numero_Factura FROM factura";
                $result = $conexion->query($SentenciaSQL);
                $facturas = $result->fetchAll();

                foreach ($facturas as $factura) { ?>
                    <option value="<?php echo $factura["Numero_Factura"]; ?>"><?php echo $factura["Numero_Factura"]; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="Referencia">Referencia de Repuesto:</label>
            <select name="Referencia">
                <?php
                $SentenciaSQL = "SELECT Referencia FROM repuestos";
                $result = $conexion->query($SentenciaSQL);
                $repuestos = $result->fetchAll();

                foreach ($repuestos as $repuesto) { ?>
                    <option value="<?php echo $repuesto["Referencia"]; ?>"><?php echo $repuesto["Referencia"]; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="Unidades">Número de Unidades:</label>
            <input type="number" id="Unidades" name="Unidades">
        </div>

        <button type="submit">Guardar Línea de Factura</button>
        <input type=reset value="Borrar datos">
    </form>
</body>
</html>