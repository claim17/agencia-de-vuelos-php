<?php
include("seguridad.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal - Taller Náutico</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff;
            color: #333;
        }
        
        .header {
            background-color: #1e3a8a;
            color: white;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .header h1 {
            margin: 0;
            font-size: 2.5em;
        }
        
        .header p {
            margin: 10px 0 0;
            font-size: 1.2em;
            opacity: 0.9;
        }
        
        .user-info {
            background-color: #2c5282;
            color: white;
            padding: 10px 20px;
            text-align: right;
        }
        
        .user-info span {
            font-weight: bold;
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        
        .menu-item {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }
        
        .menu-item-header {
            background-color: #3182ce;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 1.3em;
            font-weight: bold;
        }
        
        .menu-item-content {
            padding: 20px;
        }
        
        .menu-item-content ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        
        .menu-item-content li {
            margin-bottom: 12px;
        }
        
        .menu-item-content a {
            display: block;
            padding: 10px 15px;
            background-color: #ebf8ff;
            color: #2b6cb0;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.2s;
            font-weight: 500;
        }
        
        .menu-item-content a:hover {
            background-color: #bee3f8;
        }
        
        .logout-container {
            text-align: center;
            margin-top: 40px;
        }
        
        .logout-btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #e53e3e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        
        .logout-btn:hover {
            background-color: #c53030;
        }
        
        .footer {
            background-color: #1e3a8a;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 40px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="user-info">
        Bienvenido, <span>admin</span>
    </div>
    
    <div class="header">
        <h1>Taller Náutico</h1>
        <p>Sistema de Gestión</p>
    </div>
    
    <div class="container">
        <div class="menu-grid">
            <div class="menu-item">
                <div class="menu-item-header">Clientes</div>
                <div class="menu-item-content">
                    <ul>
                        <li><a href="listar.php">Ver Clientes</a></li>
                        <li><a href="introducir_clientes.php">Añadir Cliente</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="menu-item">
                <div class="menu-item-header">Embarcaciones</div>
                <div class="menu-item-content">
                    <ul>
                        <li><a href="listar_barcos.php">Ver Embarcaciones</a></li>
                        <li><a href="introducir_barcos.php">Añadir Embarcación</a></li>
                        <li><a href="buscar_barco.php">buscar Embarcación</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="menu-item">
                <div class="menu-item-header">Facturas</div>
                <div class="menu-item-content">
                    <ul>
                        <li><a href="lista_facturas.php">Ver Facturas</a></li>
                        <li><a href="introducir_factura.php">Crear Factura</a></li>
                        <li><a href="insertar_solo_linea.php">Añadir Línea a Factura</a></li>
                        <li><a href="ajax/buscador_facturas.php" class="menu-button">Buscador AJAX de Facturas</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="menu-item">
                <div class="menu-item-header">Repuestos</div>
                <div class="menu-item-content">
                    <ul>
                        <li><a href="lista_repuestos.php">Ver Repuestos</a></li>
                        <li><a href="introducir_repuestos.php">Añadir Repuesto</a></li>
                    </ul>
                </div>
            </div>
        </div>

        
        
        <div class="logout-container">
            <a href="cerrarsesion.php" class="logout-btn">Cerrar Sesión</a>
        </div>
    </div>
    
    <div class="footer">
        &copy; <?php echo date('Y'); ?> Taller Náutico - Todos los derechos reservados
    </div>
</body>
</html>