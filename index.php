
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/stylesPrincipal.css">
    <script src="https://kit.fontawesome.com/b965409e0d.js" crossorigin="anonymous"></script>
</head>

<?php
    include_once("modelo/consultas.php");
    $obConex = new Consultas();
    // LA COMPARACION SE ARA CON LA IMAGEN QUE SE ESCANEE
    $sql=$obConex->buscarTodos("SELECT num_mesa FROM mesas WHERE id_mesa='1'");
    $numMesa=$sql[0][0];
?>

        <div class="contenedorEscaner">
            <h1>RESTAURANTE ARTEA</h1>
            <p>ESCANEE EL CODIGO QR DE LA MESA</p>
            <div>
                <p>AQUI VA EL SCANEER O LA CAMARA</p>
            </div>
            
            <form name="tabla" method="post" action="nuevaOrden.php">
                <p><br> N&uacute;mero de mesa: <br></p>
                <p><?php echo $numMesa ?></p>
                <input type="hidden" name="bandera" value="false">
                <input type="hidden" name="mesa" value="<?php echo $numMesa?>">
                <br><br>
                <button type="submit" name="ordenarB" class="botonA2">Ordenar<i class="fas fa-shopping-cart"></i></button>
            </form>
        </div>

<style>
.contenedorEscaner{
    text-align: center;
}

</style>