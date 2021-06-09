<?php
    header("Location: carrito2.php");  
    include_once("modelo/consultas.php");
    $obProm = new Consultas();
    $idDet=$_GET['no']; //RECIBO ID_DETALLE DE LA VISTA
    $sql="SELECT id_orden, id_prod, cantidad, total FROM detalle_orden WHERE id_detalle=".$idDet;
    $bus=$obProm->buscarTodos($sql);
    $idO=$bus[0][0]; //id orden
    $idProd=$bus[0][1]; //id producto
    $cant=$bus[0][2]; //cantidad
    $total=$bus[0][3]; //total
    $cantN=$cant-1; //cantidad nueva para ddetalle_orden
    $totalN=$total-($total/$cant);

    if($cantN==0){
        $sql2="DELETE FROM detalle_orden WHERE id_detalle=".$idDet;
        $obProm->ejecutar($sql2);

    }else{
        $sql3="UPDATE detalle_orden SET cantidad= '".$cantN."', total= '".$totalN."' WHERE id_detalle=".$idDet;
        $obProm->ejecutar($sql3);
    }  
    $sql4="SELECT cant_producto, total_orden FROM orden WHERE id_orden=".$idO;
        $bus2=$obProm->buscarTodos($sql4);
        $can=$bus2[0][0]; //cant_producto
        $tot=$bus2[0][1]; //total_orden
        $cantON=$can-1; //nueva cantidad_producto 
        $totalON=$tot-($total/$cant); //nuevo total_orden
        
    if($can==0){
        $sql6="DELETE FROM orden WHERE id_orden=".$idO;
        $obProm->ejecutar($sql6);
    }else{
        $sql5="UPDATE orden SET cant_producto='".$cantON."', total_orden= '".$totalON."' WHERE id_orden=".$idO;
        $obProm->ejecutar($sql5);
    }
?>
