<?php
include("conexionPDO.php");
include("seguridad.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Línea de Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #3498db;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }
        select, input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        select:focus, input:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        button, input[type="reset"] {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        button[type="submit"] {
            background-color: #2ecc71;
            color: white;
            flex: 1;
            margin-right: 10px;
        }
        button[type="submit"]:hover {
            background-color: #27ae60;
        }
        input[type="reset"] {
            background-color: #e74c3c;
            color: white;
            flex: 1;
            margin-left: 10px;
        }
        input[type="reset"]:hover {
            background-color: #c0392b;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Añadir Línea de Factura</h1>
        
        <form method="POST" action="insertar_linea_factura.php">
            <div class="form-group">
                <label for="Numero_Factura">Número de Factura:</label>
                <select name="Numero_Factura" id="Numero_Factura" required>
                    <option value="">Seleccione una factura</option>
                    <?php
                    $SentenciaSQL = "SELECT f.Numero_Factura, e.Matricula, c.Nombre, c.Apellido1 
                                    FROM factura f 
                                    LEFT JOIN embarcaciones e ON f.Matricula = e.Matricula 
                                    LEFT JOIN clientes c ON e.Id_Cliente = c.Id_Cliente 
                                    ORDER BY f.Numero_Factura DESC";
                    $result = $conexion->query($SentenciaSQL);
                    $facturas = $result->fetchAll();

                    foreach ($facturas as $factura) { 
                        $info_factura = "Factura #" . $factura["Numero_Factura"] . " - " . 
                                        $factura["Matricula"] . " - " . 
                                        $factura["Nombre"] . " " . $factura["Apellido1"];
                    ?>
                        <option value="<?php echo $factura["Numero_Factura"]; ?>"><?php echo $info_factura; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="Referencia">Repuesto:</label>
                <select name="Referencia" id="Referencia" required>
                    <option value="">Seleccione un repuesto</option>
                    <?php
                    $SentenciaSQL = "SELECT Referencia, Descripcion, Importe, Ganancia FROM repuestos ORDER BY Descripcion";
                    $result = $conexion->query($SentenciaSQL);
                    $repuestos = $result->fetchAll();

                    foreach ($repuestos as $repuesto) { 
                        $precio = $repuesto["Importe"] + ($repuesto["Importe"] * ($repuesto["Ganancia"] / 100));
                        $info_repuesto = $repuesto["Referencia"] . " - " . 
                                        $repuesto["Descripcion"] . " - " . 
                                        number_format($precio, 2, ',', '.') . "€";
                    ?>
                        <option value="<?php echo $repuesto["Referencia"]; ?>"><?php echo $info_repuesto; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="Unidades">Unidades:</label>
                <input type="number" id="Unidades" name="Unidades" min="1" value="1" required>
            </div>

            <div class="button-group">
                <button type="submit">Añadir Línea</button>
                <input type="reset" value="Borrar datos">
            </div>
        </form>
        
        <a href="lista_facturas.php" class="back-link">← Volver a la lista de facturas</a>
    </div>
</body>
</html>