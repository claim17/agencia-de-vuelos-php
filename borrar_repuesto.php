<?php
    include "conexionPDO.php";
    
    $array_borrados =$_POST["borrarre"];
    $error=0;
    $count = count($array_borrados);
    for($i=0; $i<$count ;$i++){
        $SentenciaSQL="DELETE FROM repuestos WHERE Referencia=".$array_borrados[$i];

        //creamos la consulyta
        $resultado = $conexion->query($SentenciaSQL);

        if(!$resultado){
            $error=1;
        }

        if($error==0){
            echo "<br>Los clientes se han borrado correctamente";
        }
        
    }

?>