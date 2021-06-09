<head>
	<link rel="stylesheet" href="css/stylesTarjeta.css">
	<script src="https://kit.fontawesome.com/b965409e0d.js" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css?family=Lato|Liu+Jian+Mao+Cao&display=swap" rel="stylesheet">
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

	include_once("menu.php");
	$sqlVista="SELECT nombre_producto, precio_producto, cantidad, total FROM condetalle WHERE id_orden=".$idOrden;
	$resVista=$obProm->buscarTodos($sqlVista);
?>
<br>
<div class="todo">
	<div class="todo1">
		<?php include_once("resumenPedido.php"); ?>
	</div>
	<div class="todo2">
		<div class="div-tar">
			<h1>PAGO CON TARJETA</h1><br>
			<p>Ingrese sus datos correctamente.</p>
		</div>
		<div class="contenedorTarjeta">

			<!-- Tarjeta -->
			<div class="tarjeta" id="tarjeta">
				<div class="delantera">
					<div class="logo-marca" id="logo-marca">

					</div>
					<img src="img/chip-tarjeta.png" class="chip" alt="">
					<div class="datos">
						<div class="grupo" id="numero">
							<p class="label">Número Tarjeta</p>
							<p class="numero">#### #### #### ####</p>
						</div>
						<div class="flexbox">
							<div class="grupo" id="nombre">
								<p class="label">Nombre Tarjeta</p>
								<p class="nombre">Nombre Apellido</p>
							</div>

							<div class="grupo" id="expiracion">
								<p class="label">Expiracion</p>
								<p class="expiracion"><span class="mes">MM</span> / <span class="year">AA</span></p>
							</div>
						</div>
					</div>
				</div>

				<div class="trasera">
					<div class="barra-magnetica"></div>
					<div class="datos">
						<div class="grupo" id="firma">
							<p class="label">Firma</p>
							<div class="firma"><p></p></div>
						</div>
						<div class="grupo" id="ccv">
							<p class="label">CCV</p>
							<p class="ccv"></p>
						</div>
					</div>
					<p class="leyenda">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus exercitationem, voluptates illo.</p>
				</div>
			</div>

			<!-- Contenedor Boton Abrir Formulario -->
			<div class="contenedor-btn">
				<button class="btn-abrir-formulario" id="btn-abrir-formulario">
					<i class="fas fa-plus"></i>
				</button>
			</div>

			<!-- Formulario -->
			<form id="formulario-tarjeta" class="formulario-tarjeta" method="post" action="Recibo.php">
				<div class="grupo">
					<label for="inputNumero">Número Tarjeta</label>
					<input type="text" id="inputNumero" maxlength="19" autocomplete="off" require>
				</div>
				<div class="grupo">
					<label for="inputNombre">Nombre</label>
					<input type="text" id="inputNombre" maxlength="19" autocomplete="off">
				</div>
				<div class="flexbox">
					<div class="grupo expira">
						<label for="selectMes">Expiracion</label>
						<div class="flexbox">
							<div class="grupo-select">
								<select name="mes" id="selectMes">
									<option disabled selected>Mes</option>
								</select>
								<i class="fas fa-angle-down"></i>
							</div>
							<div class="grupo-select">
								<select name="year" id="selectYear">
									<option disabled selected>Año</option>
								</select>
								<i class="fas fa-angle-down"></i>
							</div>
						</div>
					</div>

					<div class="grupo ccv">
						<label for="inputCCV">CCV</label>
						<input type="text" id="inputCCV" maxlength="3">
					</div>
				</div>
				<input type="hidden" name="ordenId" value='<?php echo $idOrden?>'>

				<button type="submit" class="btn-enviar">Pagar</button>
			</form>
		</div>
	</div>
</div>

<script src="js/mainTarjeta.js"></script>