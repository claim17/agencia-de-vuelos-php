<?php

    foreach(glob("/temporales/*.tmp ") as $nombrearchivo ){

        unlink($nombrearchivo) ;
    }


?>