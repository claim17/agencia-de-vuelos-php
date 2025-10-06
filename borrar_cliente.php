<?php
    include "conexionPDO.php";
    
    $array_borrados =$_POST["borrar"];
    $error=0;
    $count = count($array_borrados);
    for($i=0; $i<$count ;$i++){
        $SentenciaSQL="DELETE FROM clientes WHERE id_Cliente=".$array_borrados[$i];

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