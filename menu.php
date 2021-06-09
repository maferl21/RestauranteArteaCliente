<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/stylePrincipal.css">
    <script src="https://kit.fontawesome.com/b965409e0d.js" crossorigin="anonymous"></script>
</head>
<?php
    $_SESSION["NumMesa"];
    $m=$_SESSION['NumMesa'];
?>
<body>
    <div class="divContenedor">
        <nav>
        <!-- <img id="logo" src="img/logoChico.jpeg" alt="Logo"> -->
            <!--<div id="buscador">-->
            <!--    <table class="contenedorB">-->
            <!--        <tr>-->
            <!--            <td>-->
            <!--                <input type="text" placeholder="Buscar" class="buscar">-->
            <!--            </td>-->
            <!--            <td>-->
            <!--                <a href="#" id="lupa"><i class="fas fa-search"></i></a>-->
            <!--            </td>-->
            <!--        </tr>-->
            <!--    </table>-->
            <!--</div>-->
            <img id="logo" src="img/logoChico.jpeg" alt="Logo">
            <ul id="menu">
                <li class="mesa" id="mesa">Mesa <?php echo $_SESSION['NumMesa'] ?></li>
                <li><a href="#" name="menuT">Men&uacute;</a>
                    <ul id="submenu">
                        <li> <a href="promociones.php">Promociones</a></li>
                        <li> <a href="desayunos.php">Desayuno</a></li>
                        <li> <a href="almuerzo.php">Almuerzo</a></li>
                        <li> <a href="cena.php">Cena</a></li>
                        <li> <a href="bebidas.php">Bebidas</a></li>
                        <li> <a href="postres.php">Postres</a></li>
                    </ul>
                </li>
                <li><a href="#">¿Quienes somos?</a>
                    <ul id="submenu">
                        <li><a href="contactos.php">Contactos del restaurante</a></li>
                    </ul>
                </li>
                <li><a href="#" id="carrito"><i class="fas fa-shopping-cart"></i>  Mi pedido</a>
                    <ul id="submenu">
                        <li><a href="carrito2.php">Mis compras</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    
    <header>
        <img class="imgG" src="img/imgEncabezado2.png" alt="Banner">
    </header>

</body>
</html>