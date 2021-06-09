<?php include_once("menu.php"); ?>
<head>
    <link rel="stylesheet" type="text/css" href="css/styleCar.css"> 
    <link rel="stylesheet" type="text/css" href="css/styleForma.css"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b965409e0d.js" crossorigin="anonymous"></script>
</head>

<?php
    include_once("modelo/consultas.php");
    
    $obProm = new Consultas();
    $sql="";

    //RECIBO LAS VARIABLES DEL BOTON AGREGAR DE CADA PAGINA DEL MENU
    $idR=$_POST['numIdprod'];
    $precioR=$_POST['precioProd'];
    $cantR=$_POST['cant'];
    $totalP=$cantR*$precioR; //precio total de un producto nuevo
    
        $numMesaRecibida = $_SESSION['NumMesa'];
        $idOrdenRecibida = $_SESSION['nuevaOrden'];
        
        $sqlBuscaOrden="SELECT * FROM orden WHERE id_orden =".$idOrdenRecibida." AND num_mesa=".$numMesaRecibida; 
        $ResultadoOrdenNueva=$obProm->buscarTodos($sqlBuscaOrden);
        $idUO=$ResultadoOrdenNueva[0][0]; //Id orden
        $fechaUO=$ResultadoOrdenNueva[0][1]; //fecha orden
        $cantUO=$ResultadoOrdenNueva[0][2];//Cantidad
        $mesaUO=$ResultadoOrdenNueva[0][3];//Mesa 
        $totalUO=$ResultadoOrdenNueva[0][4];//Total 
        $formaUO=$ResultadoOrdenNueva[0][5];//Forma de pago
        $recepUO=$ResultadoOrdenNueva[0][6];//Id recepcionista 

        if($idUO==$idOrdenRecibida && $mesaUO==$numMesaRecibida){
            // echo "ENTRA AL IF, LO QUE SIGNIFICA QUE SE CREO UNA ORDEN NUEVA Y COINCIDE";
            if($formaUO==""){
                //SI ENTRA ES POR QUE AUN NO ACABA DE ORDENAR
                if(isset($idR)){
                    try {
                        //CUANDO YA HAY UN PRODUCTO RELACIONADO CON LA ULTIMA ORDEN
                        $sqlBusODE = "SELECT id_detalle FROM detalle_orden WHERE id_orden =".$idOrdenRecibida;
                        $busRegDOU = $obProm->buscarDetalle($sqlBusODE);//REGRESA FALSO SI NO ENCUENTRA VALOR
            
                        if ($busRegDOU){
                            // HAY PRODUCTOS EN EL CARRITO
                            $cantAO=$cantUO+$cantR; //cant nueva de tabla orden
                            $totalAO=$totalUO+$totalP; //total nuevo tabla orden
                            
                            // BUSCA UN PRODUCTO EXISTENTE EN LA TABLA DE DETALLES
                            $sqlBusProdD="SELECT id_orden, cantidad, total FROM detalle_orden WHERE id_orden =".$idOrdenRecibida." AND id_prod=".$idR;
                            $BusProdD = $obProm->buscarTodos($sqlBusProdD);

                            // SI EXISTE UN PRODUCTO LO MODIFICA
                            if($BusProdD!=null){
                                $BusProdD0=$BusProdD[0][0]; //id orden
                                $BusProdD1=$BusProdD[0][1]; //Cantidad
                                $BusProdD2=$BusProdD[0][2]; //Precio
                                
                                $cantProdDN=$BusProdD1+$cantR; //cantidad modifica en la tabla detalle_orden
                                $precioProdDN=$BusProdD2+$totalP; //cantidad modifica en la tabla detalle_orden
                                // MODIFICA TABLA DETALLES
                                $sqlModProdD="UPDATE detalle_orden SET cantidad='".$cantProdDN."',total = '".$precioProdDN."' WHERE id_orden = ".$BusProdD0." AND id_prod = ".$idR;
                                $obProm->ejecutar($sqlModProdD);
                                
                                // MODIFICA TABLA ORDEN
                                $cantProdON=$cantUO+$cantProdDN;
                                $precioProdON=$totalUO+$precioProdDN;
                                $sqlModProdO="UPDATE orden SET cant_producto='".$cantAO."',total_orden = '".$totalAO."' WHERE id_orden = ".$idOrdenRecibida; 
                                $obProm->ejecutar($sqlModProdO);
                            }else {
                                // ENTRA ELSE REFERENCIANDO K NO EXISTE ESE PRODUCTO
                                $obProm->insertarPedido($idOrdenRecibida, $idR, $cantR, $totalP); //INSERTAR EN TABLA DETALLE
                                $obProm->modificarOrden($idOrdenRecibida, $cantAO, $totalAO);
                            }
                        }else{
                            // echo "<p>No existe pedido en carrito</p>";
                            $obProm->insertarPedido($idOrdenRecibida, $idR, $cantR, $totalP); //INSERTAR EN TABLA DETALLE
                            $obProm->modificarOrden($idOrdenRecibida, $cantR, $totalP);
                        }

                        // VISUALIZAR VISTA DETALLES
                        $sqlVista="SELECT * FROM condetalle WHERE id_orden=".$idOrdenRecibida;
                        $resVista=$obProm->buscarTodos($sqlVista);
?>
                            <section>
                                <br>
                                    <!-- SI HAY PEDIDOS QUE COINCIDAN CON LA ULTIMA ORDEN -->
                                        <?php 
                                        if ($resVista){ ?>
                                                <div class="contenedorC">
                                                    <h1>MI COMPRAS</h1>
                                                    <br><br>
                                                    <table class="tabla">
                                                        <tr class="trB">
                                                            <th>Imagen</th>
                                                            <th>Platillo/Bebida</th>
                                                            <th>Precio </th>
                                                            <th>Cantidad</th>
                                                            <th>Total</th>
                                                            <th>Eliminar</th>
                                                        </tr>
                                                    <?php 
                                                        foreach($resVista as $aLinea){
                                                    ?>
                                                        <tr class="trB">
                                                            <td class="tdB"><img class="imgR" src="data:image/jpg;base64, <?php echo base64_encode($aLinea[2])?>" alt="Imagen del producto"></td>
                                                            <td class="tdB"><?php echo $aLinea[3]?></td>
                                                            <td class="tdB"><?php echo $aLinea[4]?></td>
                                                            <td class="tdB"><?php echo $aLinea[5]?></td>
                                                            <td class="tdB"><?php echo $aLinea[6]?></td>
                                                            <td class="tdB"><a href='eliminarProd.php?no="<?php echo $aLinea[0]?>"'><button class="delete"><i class="far fa-trash-alt"></i>Eliminar</button></a></td> 
                                                        </tr>
                                                        <?php } ?>
                                                    </table>                
                                                </div>
                                    <?php
                                        $sqll="SELECT total_orden FROM orden WHERE id_orden=".$idUO;
                                        $bus2=$obProm->regresaUnValor($sqll);
                                    ?>
                                        <br><br>
                                        <div class="tablaP">
                                            <div class="box1"> <br><p class="tot"><b>Total </b>$ <?php echo number_format($bus2,2);?></p><br></div>
                                            <div class="box2"><a ><button class="pagarB" onclick="abrir();">Pagar</button></a></div>
                                        </div>
                                        <br><br><br>

                                    <?php
                                    }
                                    ?>    
                            </section>

                        <!-- VENTANA EMERGENTE DE FORMAS DE PAGO -->
                            <div class="popup" id="ventana" style="display:none">
                                <div class="popup-content">
                                    <br>
                                    <a href="javascript:cerrar()"><button class="closeB"><i class="fas fa-times"></i></button></a>
                                    <h1>FORMAS DE PAGO</h1>   
                                    <br><br>
                                    <a href='Tarjeta.php?no="<?php echo $idOrdenRecibida?>"'><button class="elegirB">Tarjeta de crédito/débito</button></a>
                                    <br><br>
                                    <a href='Recibo2.php?no="<?php echo $idOrdenRecibida?>"'><button class="elegirB">Efectivo</button></a>
                                </div>
                            </div>

                            <script>
                                function abrir(){
                                    document.getElementById("ventana").style.display="flex";
                                }
                                function cerrar(){
                                    document.getElementById("ventana").style.display="none";
                                }
                            </script>
<?php
                    }catch(Exception $e){
                        error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
                        $sErr = "Error en base de datos, comunicarse con el administrador";
                    }
                }else{
            ?>
                    <h1 class="error">No hay nada en el carrito</h1>
            <?php
                }
            ?>
        <?php
            }else{
        ?>
                <br><h1 class="ordenCerrada">NO SE PUEDE AGREGAR M&Aacute;S A SU CARRITO, SU PEDIDO ESTA EN PROCESO..</h1>
        <?php
            }
        }else{ ?>
            <h1 class="error">No hay una orden</h1>
        <?php }
        ?>        


<section>
    <br>

<?php
    include_once("pie.html");
?> 