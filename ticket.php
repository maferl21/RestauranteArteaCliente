<?php
    ob_start();
    require('../lib/fpdf.php');
    // include_once("modelo/consultas.php");
    class PDF extends fpdf{
        
        function header(){
            $this->SetFont('times','B', 16);
            $this->Cell(60);
            $this->Cell(70,10, "Restaurante Artea",0,0,'C',0); //c para centrado
            $this->Cell(60);
            $this->Ln(20); //salto de linea
        }

        function footer(){
            $this->SetY(-15); 
            $this->SetFont('times','B',8);
            $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');
        }
    }
    include_once("modelo/consultas.php");
    $obProm = new Consultas();
    $idOrden = $_GET['no'];

    //para mostrar los productos
    $sqlVista="SELECT nombre_producto, precio_producto, cantidad, total FROM condetalle WHERE id_orden=".$idOrden;
	$resVista=$obProm->buscarTodos($sqlVista);

    //buscar ticket
    $sqll12="SELECT id_ticket FROM ticket WHERE id_orden=".$idOrden;
    $bus122=$obProm->buscarTodos($sqll12);

    //para mostrar datos de orden
    $sqll="SELECT id_orden, num_mesa, total_orden FROM orden WHERE id_orden=".$idOrden;
    $bus2=$obProm->buscarTodos($sqll);
	$id=$bus2[0][0];
    $mesa=$bus2[0][1];
	$total=$bus2[0][2];

     // OBTENER FECHA ACTUAL
     date_default_timezone_set("America/Mexico_City");
     $fechaActual=date("Y")."-".date("m")."-".date("d"); //fecha actual del sistema

    if($bus122==""){ //si esta vacio es que no hay ningun ticket y hace la insercion
        //para insertar el ticket
        $query="INSERT INTO ticket(fecha_ticket,id_orden) VALUES ('".$fechaActual."', '".$id."')";
        $obProm->ejecutar($query);

        $sqll2="SELECT id_ticket, fecha_ticket FROM ticket WHERE id_orden=".$id;
        $bus22=$obProm->buscarTodos($sqll2);
        
    }else{
        $sqll2="SELECT id_ticket, fecha_ticket FROM ticket WHERE id_orden=".$id;
        $bus22=$obProm->buscarTodos($sqll2);
    }
    $folio=$bus22[0][0];
    $fecha=$bus22[0][1];
    
    $pdf = new FPDF();
    $pdf->AliasNbPages();//CREA PIE DE PAGINA
    $pdf->AddPage(); //AGREGA LA PAGINA
    $pdf->SetFont('times','B', 18);
    
    $pdf->Cell(60);
    $pdf->Cell(70,10,"Restaurante Artea",0,1,'C',0); //c para centrado
    
    $pdf->SetFont('times','B', 10);
    $pdf->SetFont('');

    //DATOS DE LA EMPRESA
    $pdf->Cell(60);
    $pdf->Cell(70,5,"RFC ARTEA-294649",0,1,'C',0);
    $pdf->Cell(60);
    $pdf->Cell(70,5,"DOMICILIO FISCAL",0,1,'C',0);
    $pdf->Cell(60);
    $pdf->Cell(70,5,"ORIZABA CENTRO, VER CP. 94300",0,1,'C',0);
    $pdf->Cell(60);
    $pdf->Cell(70,5,"TEL. 2723456283",0,1,'C',0);
    $pdf->Ln(15); 

    $pdf->SetFont('times','B', 12);

    //FOLIO
    $pdf->Cell(7);
    $pdf->Cell(30,7,"FOLIO: ",0,0,'R',0);
    $pdf->SetFont('');
    $pdf->Cell(30,7, $folio,0,1,'L',0);
    //FECHA
    $pdf->SetFont('times','B', 12);
    $pdf->Cell(8);
    $pdf->Cell(30,7,"FECHA: ",0,0,'R',0);
    $pdf->SetFont('');
    $pdf->Cell(30,7, $fecha,0,1,'L',0);
    //ORDEN
    $pdf->SetFont('times','B', 12);
    $pdf->Cell(8);
    $pdf->Cell(30,7,"ORDEN: ",0,0,'R',0);
    $pdf->SetFont('');
    $pdf->Cell(30,7, $id,0,1,'L',0);
    //MESA
    $pdf->SetFont('times','B', 12);
    $pdf->Cell(12);
    $pdf->Cell(30,7,"No. MESA: ",0,0,'R',0);
    $pdf->SetFont('');
    $pdf->Cell(30,7, $mesa,0,1,'L',0);
    
    $pdf->Cell(18);
    $pdf->Cell(30,7,"-------------------------------------------------------------------------------------------------------------",0,1,'L',0);

    $pdf->SetFont('times','B', 12);

    //PEDIDOS
    $pdf->Cell(15);
    $pdf->Cell(70,10,"Platillo/Bebida",0,0,'C',0);
    $pdf->Cell(30,10,"Precio",0,0,'C',0);
    $pdf->Cell(30,10,"Cantidad",0,0,'C',0);
    $pdf->Cell(30,10,"Total",0,1,'C',0);
    
    $pdf->SetFont('');

    if ($resVista){
        foreach($resVista as $aLinea){
            $pdf->Cell(15);
            $pdf->Cell(70,10, $aLinea[0],0,0,'C',0);
            $pdf->Cell(30,10, number_format($aLinea[1],2),0,0,'C',0);
            $pdf->Cell(30,10, $aLinea[2],0,0,'C',0);
            $pdf->Cell(30,10, number_format($aLinea[3],2),0,1,'C',0);
        }
    }
    $pdf->Ln(5); 

    $pdf->Cell(18);
    $pdf->Cell(30,7,"-------------------------------------------------------------------------------------------------------------",0,1,'L',0);
    
    $pdf->SetFont('times','B', 12);
    $pdf->Cell(125);
    $pdf->Cell(30,7,"TOTAL A PAGAR: ",0,0,'R',0);
    $pdf->SetFont('');
    $pdf->Cell(30,7, number_format($total,2),0,1,'L',0);

    $pdf->SetFont('times','B', 14);
    $pdf->Ln(13); 
    $pdf->Cell(60);
    $pdf->Cell(70,5,utf8_decode('¡GRACIAS POR TU COMPRA!'),0,1,'C',0);
    $pdf->Output();
    ob_end_flush(); 
?>