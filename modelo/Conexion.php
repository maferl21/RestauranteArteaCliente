<?php
    error_reporting(E_ALL);
    class Conexion{
        public $oConexion=null; //conexión

        /*Realiza la conexión a la base de datos*/
        function conectar(){
            $bRet = false;
                try{
                    //$this->oConexion = new PDO("pgsql:dbname=promay20_artea; host=localhost:3306; user=promay_artea; password=restaurante1234"); 
                    $this->oConexion = new PDO("mysql:host=localhost:3306;dbname=promay20_restauranteartea","promay20_artea","restaurante1234",  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'")); 
                    $bRet = true;
                }catch(Exception $e){
                    throw $e;
                }
            return $bRet;
        }
            
        /*Realiza la desconexión de la base de datos*/
        function desconectar(){
            $bRet = true;
                if ($this->oConexion != null){
                    $this->oConexion=null;
                }
            return $bRet;
        }

        /*Ejecuta en la base de datos la consulta que recibió por parámetro.
		Regresa
			Nulo si no hubo datos
			Un arreglo bidimensional de n filas y tantas columnas como campos se hayan
			solicitado en la consulta*/
      	function consulta($consulta){
            $arrRS = null;
            $rst = null;
            $oLinea = null;
            $sValCol = "";
            $i=0;
            $j=0;
            if ($consulta == ""){
               throw new Exception("Conexion->consulta: falta indicar la consulta");
            }
            if ($this->oConexion == null){
                throw new Exception("Conexion->consulta: falta conectar la base");
            }
            try{
                $rst = $this->oConexion->query($consulta); //un objeto PDOStatement o falso en caso de error
            }catch(Exception $e){
                throw $e;
            }
            if ($rst){
                foreach($rst as $oLinea){ 
                    foreach($oLinea as $llave=>$sValCol){
                        if (is_string($llave)){
                            $arrRS[$i][$j] = $sValCol;
                            $j++;
                        }
                    }
                    $j=0;
                    $i++;
                }
            } 
            return $arrRS;
        }

        //Regresa sql para que donde se llama se puedan contar los registros
        function consultaSql($consulta){
            // $arrRS = null;
            $rst = null;
            if ($consulta == ""){
               throw new Exception("Conexion->consultaSql: falta indicar la consulta");
            }
            if ($this->oConexion == null){
                throw new Exception("Conexion->consultaSql: falta conectar la base");
            }
            try{
                $rst = $this->oConexion->query($consulta); //un objeto PDOStatement o falso en caso de error
            }catch(Exception $e){
                throw $e;
            }
            return $rst;
        }

        function ejecutarComando($psComando){
            $nAfectados = -1;
            if ($psComando == ""){
                throw new Exception("Conexion->ejecutarComando: falta indicar el comando");
            }
            if ($this->oConexion == null){
                throw new Exception("Conexion->ejecutarComando: falta conectar la base");
            }
            try{
                $nAfectados =$this->oConexion->exec($psComando);
            }catch(Exception $e){
                throw $e;
            }
            return $nAfectados;
        }    
    }
?>