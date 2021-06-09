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

    $idOrdenRecibida = $_SESSION['nuevaOrden'];
    $numMesaRecibida = $_SESSION['NumMesa'];

    // VISUALIZAR VISTA CONDETALLES
    $sqlVista="SELECT * FROM condetalle WHERE id_orden=".$idOrdenRecibida;
    $resVista=$obProm->buscarTodos($sqlVista);

    $sqlBuscaOrden="SELECT id_forma FROM orden WHERE id_orden =".$idOrdenRecibida." AND num_mesa=".$numMesaRecibida; 
    $ResultadoOrdenNueva=$obProm->buscarTodos($sqlBuscaOrden);
    $formaUO=$ResultadoOrdenNueva[0][0];//Forma de pago
    if($formaUO==""){?>
        <section>
            <br>
                <?php 
                    if ($resVista==null){ 
                ?>
                        <h1 class="error">No hay nada en el carrito</h1>
                <?php
                    }else{
                ?>
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
                                        <!-- SE LE MANDA EL ID_DETALLE -->
                                        <td class="tdB"><a href='eliminarProd.php?no="<?php echo $aLinea[0]?>"'><button class="delete"><i class="far fa-trash-alt"></i>Eliminar</button></a></td> 
                                    </tr>
                            <?php } ?>
                            </table>
                        </div>
                <?php
                    $sqll="SELECT total_orden FROM orden WHERE id_orden=".$idOrdenRecibida;
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
            }else{
        ?>
                <br><h1 class="ordenCerrada">NO SE PUEDE AGREGAR M&Aacute;S A SU CARRITO, SU PEDIDO ESTA EN PROCESO..</h1>
        <?php } ?>        
<!-- <section> -->
    <br>

<?php
    include_once("pie.html");
?> 