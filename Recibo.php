<head>
    <link rel="stylesheet" href="css/styleResumen.css">
    <link rel="stylesheet" href="css/stylesTarjeta.css">
</head>

<?php
	$idOrden=$_POST['ordenId'];
    include_once("modelo/consultas.php");
    $obProm = new Consultas();

	$sQuery = "UPDATE orden SET id_forma = '2' WHERE id_orden = ".$idOrden;                    
    $obProm->modificarOrden2($sQuery);

    $sqll="SELECT id_orden, num_mesa, total_orden FROM orden WHERE id_orden=".$idOrden;
    $bus2=$obProm->buscarTodos($sqll);
	$id=$bus2[0][0];
	$mesa=$bus2[0][1];
	$total=$bus2[0][2];

	include_once("menu.php");
	$sqlVista="SELECT nombre_producto, precio_producto, cantidad, total FROM condetalle WHERE id_orden=".$idOrden;
	$resVista=$obProm->buscarTodos($sqlVista);
?>
<br>
<div class="div-tar">
    <br>
	<h1 class="gracias">¡GRACIAS POR SU COMPRA!</h1>
    <br>
    <?php if ($resVista){ ?>
			<div class="resumen">
				<div class="div-tar">
					<h1>RECIBO</h1>
				</div>
				<br>
				<p><b>Orden: </b><?php echo $id ?></p>
				<br>
				<p><b>No. Mesa: </b><?php echo $mesa ?></p>
				<div class="contenedorC2">
					<br>
					<table class="tabla">
						<tr class="trB">
							<th>Platillo/Bebida</th>
							<th>Precio </th>
							<th>Cantidad</th>
							<th>Total</th>
						</tr>
						<?php 
							foreach($resVista as $aLinea){
						?>
							<tr class="trB">
								<td class="tdB"><?php echo $aLinea[0]?></td>
								<td class="tdB"><?php echo $aLinea[1]?></td>
								<td class="tdB"><?php echo $aLinea[2]?></td>
								<td class="tdB"><?php echo $aLinea[3]?></td>
							</tr>
						<?php } ?>
					</table>                
				</div>
				<br><p class="tot"><b>Total a pagar </b>$ <?php echo number_format($total,2);?></p><br>
			</div>
		<?php } ?>
        <br>
    <a target="_BLANK" href='ticket.php?no="<?php echo $id?>"'><button>Imprimir ticket</button></a>
    <br><br>
</div>

<?php
    include_once("pie.html");
?>
