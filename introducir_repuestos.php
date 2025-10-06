<?php
include("conexionPDO.php");
include("seguridad.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Repuesto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
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
            margin-bottom: 25px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }
        input[type="number"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        input[type="number"]:focus,
        textarea:focus {
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
        <h1>Insertar Nuevo Repuesto</h1>

        <form method="POST" action="insertar_repuestos2.php">
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" placeholder="Ingrese la descripción del repuesto" required></textarea>
            </div>

            <div class="form-group">
                <label for="importe">Importe (€):</label>
                <input type="number" id="importe" name="importe" step="0.01" min="0" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label for="ganancia">Ganancia (%):</label>
                <input type="number" id="ganancia" name="ganancia" min="0" max="100" placeholder="0" required>
            </div>

            <div class="button-group">
                <button type="submit">Guardar Repuesto</button>
                <input type="reset" value="Borrar datos">
            </div>
        </form>
        
        <a href="lista_repuestos.php" class="back-link">← Volver a la lista de repuestos</a>
    </div>
</body>
</html>