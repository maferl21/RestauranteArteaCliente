<?php
    include_once("menu.php");
    include("promociones.php");
    $mesa=$_POST['mesa']; //numero de mesa recibida del qr
    $_SESSION["NumMesa"]=$mesa;
    include_once("modelo/consultas.php");
    $oConex = new Consultas();

    // OBTENER FECHA ACTUAL
    date_default_timezone_set("America/Mexico_City");
    $fechaActual=date("Y")."-".date("m")."-".date("d"); //fecha actual del sistema
    
    if(isset($_POST['ordenarB'])){
        // BUSCAR EL ID DE LA MESA
        $sqlMesa="SELECT id_mesa FROM mesas WHERE num_mesa=".$mesa; 
        $IDmesa=$oConex->regresaUnValor($sqlMesa);
    
        //BUSCA EL ID MAXIMO POR LO QUE ES LA ULTIMA ORDEN
        $sqlUO = $oConex->regresaUnValor("SELECT id_orden FROM orden WHERE id_orden=(SELECT MAX(id_orden)FROM orden)");
        if($sqlUO!=null){
            $sqlNuevaOrden="INSERT INTO orden (fecha, num_mesa) VALUES ('".$fechaActual."','".$IDmesa."')";
            $nuevaOrden=$oConex->ejecutar($sqlNuevaOrden);
            
            $sqlUO2 = $oConex->buscarTodos("SELECT id_orden FROM orden WHERE id_orden=(SELECT MAX(id_orden)FROM orden)");
            $numNOrden=$sqlUO2[0][0]; //Id de la ultima orden
        }else{
            $sqlNuevaOrden="INSERT INTO orden (id_orden, fecha, num_mesa) VALUES ('1','".$fechaActual."','".$IDmesa."')";
            $nuevaOrden=$oConex->ejecutar($sqlNuevaOrden);
            $numNOrden=1; //numero de nueva orden
        }
        
        $_SESSION["nuevaOrden"]=$numNOrden;
?>

<br> <br>

<?php
    }else{
?>
        <p class="mensaje">Debe escanear el codigo Qr y dar click en <b>Ordenar</b></p>
<?php
    }
?>
