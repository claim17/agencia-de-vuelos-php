<?php
include("../conexionPDO.php");
include("../seguridad.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscador de Facturas</title>
    <style>
        .container { width: 80%; margin: 20px auto; }
        select { width: 100%; margin: 10px 0; padding: 5px; }
        #tabla_facturas { width: 100%; border-collapse: collapse; }
        #tabla_facturas th, #tabla_facturas td { 
            border: 1px solid #ddd; 
            padding: 8px; 
        }
        #tabla_facturas tr:hover { background-color: #f5f5f5; }
        .btn-modificar {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .btn-modificar:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function crearXMLHttpRequest() {
            if (window.XMLHttpRequest) {
                return new XMLHttpRequest();
            } else {
                return new ActiveXObject("Microsoft.XMLHTTP");
            }
        }

        function cargarMatriculas() {
            var dni = document.getElementById('dni').value;
            var xhr = crearXMLHttpRequest();
            
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    console.log('Status:', xhr.status);
                    console.log('Response Text:', xhr.responseText);
                    
                    if (xhr.status == 200) {
                        try {
                            var xml = xhr.responseXML;
                            var select = document.getElementById('matricula');
                            select.innerHTML = '<option value="">Seleccione una matrícula</option>';
                            
                            if (xml) {
                                var matriculas = xml.getElementsByTagName('matricula');
                                console.log('Número de matrículas:', matriculas.length);
                                
                                for(var i = 0; i < matriculas.length; i++) {
                                    var valor = matriculas[i].textContent || matriculas[i].firstChild.data;
                                    select.innerHTML += '<option value="' + valor + '">' + valor + '</option>';
                                }
                            } else {
                                console.error('XML response is null');
                            }
                        } catch(e) {
                            console.error('Error processing XML:', e);
                        }
                    } else {
                        console.error('HTTP Error:', xhr.status);
                    }
                }
            };
            
            xhr.open('POST', 'get_matriculas.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('dni=' + encodeURIComponent(dni));
        }

        function cargarFacturas() {
            var matricula = document.getElementById('matricula').value;
            var xhr = crearXMLHttpRequest();
            
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var xml = xhr.responseXML;
                    var tabla = '<tr><th>Número</th><th>Fecha</th><th>Base Imponible</th><th>IVA</th><th>Total</th><th>Acciones</th></tr>';
                    
                    var facturas = xml.getElementsByTagName('factura');
                    for(var i = 0; i < facturas.length; i++) {
                        var factura = facturas[i];
                        var numero = factura.getElementsByTagName('numero')[0].firstChild.data;
                        tabla += '<tr>' +
                                '<td>' + numero + '</td>' +
                                '<td>' + factura.getElementsByTagName('fecha')[0].firstChild.data + '</td>' +
                                '<td>' + factura.getElementsByTagName('base')[0].firstChild.data + ' €</td>' +
                                '<td>' + factura.getElementsByTagName('iva')[0].firstChild.data + '%</td>' +
                                '<td>' + factura.getElementsByTagName('total')[0].firstChild.data + ' €</td>' +
                                '<td><button onclick="verDetalles(' + numero + ')" class="btn-modificar">Modificar</button></td></tr>';
                    }
                    document.getElementById('tabla_facturas').innerHTML = tabla;
                }
            };
            
            xhr.open('POST', 'get_facturas_xml.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('matricula=' + encodeURIComponent(matricula));
        }

        function verDetalles(numeroFactura) {
            window.location.href = '../detalles_factura.php?numero_factura=' + numeroFactura;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Buscador de Facturas</h1>
        
        <select id="dni" onchange="cargarMatriculas()">
            <option value="">Seleccione un DNI</option>
            <?php
            $sql = "SELECT DISTINCT DNI FROM clientes ORDER BY DNI";
            $result = $conexion->query($sql);
            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='".$row['DNI']."'>".$row['DNI']."</option>";
            }
            ?>
        </select>

        <select id="matricula" onchange="cargarFacturas()">
            <option value="">Seleccione una matrícula</option>
        </select>

        <table id="tabla_facturas">
        </table>
    </div>
</body>
</html>