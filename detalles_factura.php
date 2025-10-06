<?php
include("conexionPDO.php");
include("seguridad.php");

// Check if numero_factura is set in the URL
if(!isset($_GET["numero_factura"])) {
    echo "<script>alert('Número de factura no especificado'); window.location.href='lista_facturas.php';</script>";
    exit;
}

$numero_factura = $_GET["numero_factura"];

// Add debugging
echo "<!-- Procesando factura: " . $numero_factura . " -->";

// Check if form was submitted for updating
if(isset($_POST['actualizar'])) {
    // Redirect to the processing script
    header("Location: actualizar_factura_detalles.php");
    exit;
}

// Simplify the query to troubleshoot
$sql = "SELECT * FROM factura WHERE Numero_Factura = '$numero_factura'";
$result = $conexion->query($sql);

if(!$result) {
    echo "<p>Error en la consulta: " . $conexion->errorInfo()[2] . "</p>";
    exit;
}

$row = $result->fetch(PDO::FETCH_ASSOC);

if(!$row) {
    echo "<p>No se encontró la factura con número: $numero_factura</p>";
    echo "<p><a href='lista_facturas.php'>Volver a la lista</a></p>";
    exit;
}

// Now get additional data
$matricula = $row['Matricula'];
$sql_barco = "SELECT e.*, c.Nombre, c.Apellido1, c.Apellido2 
             FROM embarcaciones e 
             LEFT JOIN clientes c ON e.Id_Cliente = c.Id_Cliente 
             WHERE e.Matricula = '$matricula'";
$result_barco = $conexion->query($sql_barco);
$barco_info = $result_barco->fetch(PDO::FETCH_ASSOC);

// Get all boats for the dropdown
$sql_barcos = "SELECT e.*, c.Nombre, c.Apellido1, c.Apellido2 
              FROM embarcaciones e 
              LEFT JOIN clientes c ON e.Id_Cliente = c.Id_Cliente 
              ORDER BY e.Matricula";
$result_barcos = $conexion->query($sql_barcos);
$barcos = $result_barcos->fetchAll(PDO::FETCH_ASSOC);

// Check if linea_factura table exists before querying it
try {
    // Changed from linea_factura to detalle_factura
    $check_table = $conexion->query("SHOW TABLES LIKE 'detalle_factura'");
    $table_exists = ($check_table->rowCount() > 0);
    
    if ($table_exists) {
        // Get line items for this invoice - Changed from linea_factura to detalle_factura
        $sql_lineas = "SELECT l.*, r.Descripcion, r.Importe, r.Ganancia 
                      FROM detalle_factura l 
                      LEFT JOIN repuestos r ON l.Referencia = r.Referencia 
                      WHERE l.Numero_Factura = '$numero_factura'";
        $result_lineas = $conexion->query($sql_lineas);
        $lineas = $result_lineas->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Table doesn't exist, set lineas to empty array
        $lineas = [];
    }
} catch (PDOException $e) {
    // Handle exception - table doesn't exist or other issue
    $lineas = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="date"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .buttons {
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            margin-right: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            border: none;
            cursor: pointer;
        }
        .btn-danger {
            background-color: #f44336;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        // Function to calculate total based on form values
        function calcularTotal() {
            // Get values from form
            const baseImponible = parseFloat(document.getElementById('base_imponible').value) || 0;
            const iva = parseFloat(document.getElementById('iva').value) || 0;
            const manoDeObra = parseFloat(document.getElementById('mano_de_obra').value) || 0;
            const precioHora = parseFloat(document.getElementById('precio_hora').value) || 0;
            
            // Calculate labor cost
            const costoManoObra = manoDeObra * precioHora;
            
            // Calculate new base with labor cost
            const nuevaBase = baseImponible + costoManoObra;
            
            // Calculate total with VAT
            const total = nuevaBase + (nuevaBase * (iva / 100));
            
            // Update total field
            document.getElementById('total').value = total.toFixed(2);
        }
        
        // Initialize when document is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners to all fields that affect the total
            document.getElementById('base_imponible').addEventListener('input', calcularTotal);
            document.getElementById('iva').addEventListener('input', calcularTotal);
            document.getElementById('mano_de_obra').addEventListener('input', calcularTotal);
            document.getElementById('precio_hora').addEventListener('input', calcularTotal);
            
            // Calculate initial total
            calcularTotal();
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Editar Factura</h1>
        
        <form method="POST" action="actualizar_factura_detalles.php">
            <div class="form-group">
                <label>Número de Factura:</label>
                <input type="text" name="numero_factura" value="<?php echo $row['Numero_Factura']; ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="fecha_emision">Fecha de Emisión:</label>
                <input type="date" id="fecha_emision" name="fecha_emision" value="<?php echo $row['Fecha_Emision']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="fecha_pago">Fecha de Pago:</label>
                <input type="date" id="fecha_pago" name="fecha_pago" value="<?php echo $row['Fecha_Pago'] ?? ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="matricula">Embarcación:</label>
                <select id="matricula" name="matricula" required>
                    <option value="">Seleccione una embarcación</option>
                    <?php foreach($barcos as $barco): ?>
                    <option value="<?php echo $barco['Matricula']; ?>" <?php if($barco['Matricula'] == $row['Matricula']) echo 'selected'; ?>>
                        <?php echo $barco['Matricula'] . ' - ' . ($barco['Nombre'] ? $barco['Nombre'] . ' ' . $barco['Apellido1'] . ' ' . $barco['Apellido2'] : 'Sin propietario'); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Replace the form fields with these updated versions that include IDs -->
            <div class="form-group">
                <label for="base_imponible">Base Imponible:</label>
                <input type="number" id="base_imponible" name="base_imponible" step="0.01" value="<?php echo $row['Base_Imponible']; ?>">
            </div>
            
            <div class="form-group">
                <label for="iva">IVA (%):</label>
                <input type="number" id="iva" name="iva" step="0.01" value="<?php echo $row['IVA']; ?>">
            </div>
            
            <div class="form-group">
                <label for="mano_de_obra">Mano de Obra (horas):</label>
                <input type="number" id="mano_de_obra" name="mano_de_obra" step="0.01" value="<?php echo $row['Mano_de_Obra']; ?>">
            </div>
            
            <div class="form-group">
                <label for="precio_hora">Precio por Hora:</label>
                <input type="number" id="precio_hora" name="precio_hora" step="0.01" value="<?php echo $row['Precio_Hora']; ?>">
            </div>
            
            <div class="form-group">
                <label for="total">Total:</label>
                <input type="text" id="total" name="total" value="<?php echo number_format($row['Total'], 2, '.', ','); ?>" readonly>
            </div>
            
            <div class="buttons">
                <button type="submit" name="actualizar" class="btn">Guardar Cambios</button>
                <a href="lista_facturas.php" class="btn" style="background-color: #7f8c8d;">Cancelar</a>
                <a href="borrar_factura.php?numero_factura=<?php echo $numero_factura; ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar esta factura?');">Eliminar</a>
            </div>
        </form>
        
        <?php if(isset($lineas) && count($lineas) > 0): ?>
        <h2>Líneas de Factura</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Referencia</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
            <?php foreach($lineas as $linea): 
                // Calculate price with profit margin
                $precio_unitario = $linea['Importe'] + ($linea['Importe'] * ($linea['Ganancia'] / 100));
                $subtotal = $precio_unitario * $linea['Unidades'];
            ?>
            <tr>
                <td><?php echo $linea['Id_Det_Factura']; ?></td>
                <td><?php echo $linea['Referencia']; ?></td>
                <td><?php echo $linea['Descripcion'] ?? 'Sin descripción'; ?></td>
                <td><?php echo $linea['Unidades']; ?></td>
                <td><?php echo number_format($precio_unitario, 2, ',', '.') . " €"; ?></td>
                <td><?php echo number_format($subtotal, 2, ',', '.') . " €"; ?></td>
                <td>
                    <a href="borrar_linea_factura.php?id=<?php echo $linea['Id_Det_Factura']; ?>&numero_factura=<?php echo $numero_factura; ?>" 
                       onclick="return confirm('¿Está seguro de que desea eliminar esta línea?');" 
                       class="btn btn-danger">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <p>No hay líneas de detalle asociadas a esta factura.</p>
        <?php endif; ?>
        
        <h2>Añadir Línea de Factura</h2>
        <form method="POST" action="insertar_linea_factura.php">
            <input type="hidden" name="Numero_Factura" value="<?php echo $numero_factura; ?>">
            
            <div class="form-group">
                <label for="Referencia">Referencia de Repuesto:</label>
                <select name="Referencia" required>
                    <option value="">Seleccione un repuesto</option>
                    <?php
                    $SentenciaSQL = "SELECT Referencia, Descripcion FROM repuestos";
                    $result = $conexion->query($SentenciaSQL);
                    $repuestos = $result->fetchAll();
                    
                    foreach ($repuestos as $repuesto) { ?>
                        <option value="<?php echo $repuesto["Referencia"]; ?>"><?php echo $repuesto["Referencia"] . " - " . $repuesto["Descripcion"]; ?></option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="Unidades">Número de Unidades:</label>
                <input type="number" id="Unidades" name="Unidades" min="1" required>
            </div>
            
            <button type="submit" class="btn">Añadir Línea</button>
        </form>
    </div>
</body>
</html>