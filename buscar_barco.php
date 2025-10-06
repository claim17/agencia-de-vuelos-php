<?php
include("conexionPDO.php");
include("seguridad.php");

$conditions = array();
$params = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['longitud'])) {
        $conditions[] = "Longitud = ?";
        $params[] = $_POST['longitud'];
    }
    if (!empty($_POST['potencia'])) {
        $conditions[] = "Potencia = ?";
        $params[] = $_POST['potencia'];
    }
    if (!empty($_POST['motor'])) {
        $conditions[] = "Motor = ?";
        $params[] = $_POST['motor'];
    }
    if (!empty($_POST['anyo'])) {
        $conditions[] = "Año = ?";
        $params[] = $_POST['anyo'];
    }
    if (!empty($_POST['material'])) {
        $conditions[] = "Material = ?";
        $params[] = $_POST['material'];
    }
}

$sql = "SELECT e.*, c.Nombre, c.Apellido1, c.Apellido2 
        FROM embarcaciones e 
        LEFT JOIN clientes c ON e.Id_Cliente = c.Id_Cliente";

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conexion->prepare($sql);
if (!empty($params)) {
    $stmt->execute($params);
} else {
    $stmt->execute();
}
$barcos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Embarcaciones</title>
    <style>
        .container { width: 80%; margin: 20px auto; }
        form { margin-bottom: 20px; }
        .form-group { margin-bottom: 10px; }
        label { display: inline-block; width: 100px; }
        input, select { padding: 5px; width: 200px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        tr:hover { background-color: #f5f5f5; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Buscador de Embarcaciones</h1>
        
        <form method="POST">
            <div class="form-group">
                <label for="longitud">Longitud:</label>
                <input type="number" id="longitud" name="longitud" step="0.01" placeholder = "Metros" value=" <?php echo $_POST['longitud'] ?? ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="potencia">Potencia:</label>
                <input type="number" id="potencia" name="potencia" placeholder = "CV" value="<?php echo $_POST['potencia'] ?? ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="motor">Motor:</label>
                <select id="motor" name="motor">
                    <option value="">Todos</option>
                    <option value="Gasolina" <?php echo (isset($_POST['motor']) && $_POST['motor'] == 'Gasolina') ? 'selected' : ''; ?>>Gasolina</option>
                    <option value="Diesel" <?php echo (isset($_POST['motor']) && $_POST['motor'] == 'Diesel') ? 'selected' : ''; ?>>Diesel</option>
                    <option value="Electrico" <?php echo (isset($_POST['motor']) && $_POST['motor'] == 'Electrico') ? 'selected' : ''; ?>>Electrico</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="anyo">Año:</label>
                <input type="number" id="anyo" name="anyo" placeholder = "Año" value="<?php echo $_POST['anyo'] ?? ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="material">Material:</label>
                <select id="material" name="material">
                    <option value="">Todos</option>
                    <option value="Fibra de Vidrio" <?php echo (isset($_POST['material']) && $_POST['material'] == 'Fibra de Vidrio') ? 'selected' : ''; ?>>Fibra de Vidrio</option>
                    <option value="Aluminio" <?php echo (isset($_POST['material']) && $_POST['material'] == 'Aluminio') ? 'selected' : ''; ?>>Aluminio</option>
                    <option value="Madera" <?php echo (isset($_POST['material']) && $_POST['material'] == 'Madera') ? 'selected' : ''; ?>>Madera</option>
                    <option value="Acero" <?php echo (isset($_POST['material']) && $_POST['material'] == 'Acero') ? 'selected' : ''; ?>>Acero</option>
               
                </select>
            </div>
            
            <button type="submit">Buscar</button>
            <button type="reset">Limpiar</button>
        </form>

        <table>
            <tr>
                <th>Matrícula</th>
                <th>Longitud</th>
                <th>Potencia</th>
                <th>Motor</th>
                <th>Año</th>
                <th>Material</th>
                <th>Propietario</th>
            </tr>
            <?php foreach ($barcos as $barco): ?>
            <tr onclick="window.location='detalles_barco.php?matricula=<?php echo $barco['Matricula']; ?>'">
                <td><?php echo $barco['Matricula']; ?></td>
                <td><?php echo $barco['Longitud']; ?></td>
                <td><?php echo $barco['Potencia']; ?></td>
                <td><?php echo $barco['Motor']; ?></td>
                <td><?php echo $barco['Año']; ?></td>
                <td><?php echo $barco['Material']; ?></td>
                <td><?php echo $barco['Nombre'] . ' ' . $barco['Apellido1'] . ' ' . $barco['Apellido2']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <p><a href="menu.php">Volver al Menú</a></p>
    </div>
</body>
</html>