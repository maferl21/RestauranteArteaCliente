<?php
    require_once("Conexion.php");
    class Consultas{
        
        // Contar el numero de registro. Regresa sql para que donde se llama se puedan contar los registros
        function contar($consulta){
            $obConexion = new Conexion(); //Objeto de la conexión
            if ($obConexion->conectar()){
                    $resSql = $obConexion->consultaSql($consulta); //resultado de la consulta
                    $obConexion->desconectar(); //desconectar la base de datos
                    $num = $resSql->rowCount(); //contar el numero de registros en una tabla
            }
            return $num;
        }
        
        /*Busca todos los registros dependiendo de la consulta*/
        function buscarTodos($sql){
            $obConexion=new Conexion();
            $resSql=null;
                if ($obConexion->conectar()){
                    $resSql = $obConexion->consulta($sql);
                    $obConexion->desconectar();
                return $resSql;
            }
        }
        function regresaUnValor($sQuery){
            $obConexion=new Conexion();
            $orden="";
            $arrRS=null;
            if ($obConexion->conectar()){
                $arrRS = $obConexion->consulta($sQuery);
                $obConexion->desconectar();
                if ($arrRS){
                    $orden = $arrRS[0][0];
                }
                return $orden;
            } 
        }
        
        //BUSCA EN TABLA DETALLE SI EXISTE O NO ALGUN VALOR.
        // REGRESA FALSO SI NO HAY NINGUNA COINCIDENCIA DE LO CONTRARIO REGRESA TRUE
        function buscarDetalle($sql){
            $obConexion=new Conexion();
            $existe=false;
            $resSql=null;
                if ($obConexion->conectar()){
                    $resSql = $obConexion->consulta($sql);
                    $obConexion->desconectar();
                    if ($resSql){
                        $existe= true;
                    }
            }
            return $existe;
        }        

        function insertarPedido($idOrden, $idProd, $cant, $total){
            $obConexion=new Conexion();
            $sQuery="";
            $nAfectados=-1;
            if ($idOrden == "" OR $idProd == "" OR $cant == 0 OR $total == 0){
                throw new Exception("Consultas->insertarPedido(): faltan datos");
            }else{
                if ($obConexion->conectar()){
                    $sQuery = "INSERT INTO detalle_orden (id_orden,id_prod,cantidad,total) VALUES ('".$idOrden."','".$idProd."','".$cant."','".$total."')";
                    $nAfectados = $obConexion->ejecutarComando($sQuery);
                    $obConexion->desconectar();			
                }
            }
            return $nAfectados;
        }

        function modificarOrden($idOrden, $cant, $totalOrden){
            $obConexion=new Conexion();
            $sQuery="";
            $nAfectados=-1;
            if ($idOrden == ""){
                throw new Exception("Consultas->insertarPedido(): faltan datos");
            }else{
                if ($obConexion->conectar()){
                    $sQuery = "UPDATE orden 
					SET cant_producto= '".$cant."' , 
					total_orden = '".$totalOrden."'
					WHERE id_orden = ".$idOrden;                    
                    $nAfectados = $obConexion->ejecutarComando($sQuery);
                    $obConexion->desconectar();
                }
            }
            return $nAfectados;
        }
        
        function modificarOrden2($consulta){//, $idForma, $idRecep){
            $obConexion=new Conexion();
            $nAfectados=-1;
            if ($consulta == "")
            throw new Exception("consultas->modificarOrden2(): faltan datos");
            else{
                if ($obConexion->conectar()){
                    $nAfectados = $obConexion->ejecutarComando($consulta);
                    $obConexion->desconectar();
                }
            }
            return $nAfectados;
        }

        function ejecutar($sQuery){
            $obConexion=new Conexion();
            $nAfectados=-1;
            if ($sQuery == "")
                throw new Exception("consultas->ejecutar(): faltan datos");
            else{
                if ($obConexion->conectar()){
                    $nAfectados = $obConexion->ejecutarComando($sQuery);
                    // $obConexion->desconectar();
                }
            }
            return $nAfectados;
        }
    }
?> 