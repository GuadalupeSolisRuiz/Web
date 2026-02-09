<?php
 if($_POST['btn_comprar']){
    $Nombre = $_POST['Nombre'];
    $Fecha = $_POST['Fecha'];
    $Telefono = $_POST['Telefono'];
    $productos = $_POST['Productos'];
    $cantidad = $_POST['Cantidad'];

    if ($productos == "Correap"){
        $Total = $cantidad*50;
    }
    elseif($productos == "Correag"){
        $Total = $cantidad*60;
    }
     elseif($productos == "Camag"){
        $Total = $cantidad*150;
    }
     elseif($productos == "Casag"){
        $Total = $cantidad*350;
    }
     elseif($productos == "Casap"){
        $Total = $cantidad*250;
    }
     elseif($productos == "Camap"){
        $Total = $cantidad*89;
    }
     elseif($productos == "Noño"){
        $Total = $cantidad*25;
    }
     elseif($productos == "Comederop"){
        $Total = $cantidad*80;
    }
     elseif($productos == "Comederog"){
        $Total = $cantidad*90;
    }
    elseif($productos == "Juguete"){
        $Total = $cantidad*45;
    }

    echo "Nombre: ".$Nombre."Fecha: ".$Fecha." Telefono: ".$Telefono." Producto: ".$productos." Cantidad ".$cantidad." Total: ".$Total;
 }

?>
