<?php include_once("menu.php"); ?>
<head>
     <link rel="stylesheet" href="css/styleResumen.css">
	 <script src="https://kit.fontawesome.com/b965409e0d.js" crossorigin="anonymous"></script>
</head>
<?php
	$idOrden=$_GET['no'];
    include_once("modelo/consultas.php");
    $obProm = new Consultas();

    $sqll="SELECT id_orden, num_mesa, total_orden FROM orden WHERE id_orden=".$idOrden;
    $bus2=$obProm->buscarTodos($sqll);
	$id=$bus2[0][0];
	$mesa=$bus2[0][1];
	$total=$bus2[0][2];

	$sqlVista="SELECT nombre_producto, precio_producto, cantidad, total FROM condetalle WHERE id_orden=".$idOrden;
	$resVista=$obProm->buscarTodos($sqlVista);
?>
<br>
<?php if ($resVista){ ?>
			<div class="resumen">
				<div class="div-tar">
					<h1>RECIBO</h1>
					<br>
					<p><b>Orden: </b><?php echo $id ?></p>
					<br>
					<p><b>No. Mesa: </b><?php echo $mesa ?></p>
				</div>
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
				<div class="div-tar">
					<br><p class="tot"><b>Total a pagar </b>$ <?php echo number_format($total,2);?></p><br>
				</div>
			</div>
		<?php } ?>