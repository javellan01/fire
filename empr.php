<!DOCTYPE html>
<html><head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-2">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@2.0.0-rc.1/dist/css/coreui.min.css">

</head>
<body class=!"app">
	<!-- Seçăo 0001, um conto sobre o HTML -->
	<div style="color: #dd2211;">
		<h2> ACESSO BANCO DE DADOS GERAL<i> Sistema Firesystems </i></h2>
		<br>
		<div style="border-style: dashed; color: #911">




<ul style="list-style-type: disc">
			<li><p>Pedidos Relativos a:


    

<?php
 
$servername = "mysql.firesystems.com.br";
$username = "firesystems";
$password = "fire2014";

// Create connection

$conn = new PDO("mysql:host=mysql.firesystems.com.br;dbname=firesystems;charset=utf8", "firesystems", "fire2014");

// Check connection

$empresa = 'BIONOVIS';

echo $empresa."</p>";

	
$stmt = $conn->query("SELECT c.id_cliente, p.tx_codigo, p.cs_estado, v.medido_total, v.nb_valor FROM cliente As c 
						INNER JOIN pedido AS p ON c.id_cliente = p.id_cliente
						INNER JOIN v_sum_pedido_total AS v ON p.id_pedido = v.id_pedido
						WHERE c.tx_nome LIKE '" . $empresa . "'
						;");
						
//$stmt1 = $conn->query("SELECT c.id_cliente, p.tx_codigo, p.cs_estado FROM cliente As c 
//						INNER JOIN pedido AS p ON c.id_cliente = p.id_cliente
//						WHERE c.tx_nome LIKE '" . $empresa . "' AND p.cs_estado = 0;");	
					
if($stmt == NULL){
echo"<p> Năo Tem NADA. !! </p>";}
else{
	  

while($row = $stmt->fetch(PDO::FETCH_OBJ)){
  
echo "<div class='progress-group'>";
  if($row->cs_estado == 0) 
		echo "<div class='progress-group-header align-items-end' style='color: #27b;'><div class='font-weight-bold mr-2'>Pedido: " . $row->tx_codigo . " (Ativo)</div>";
  if($row->cs_estado == 1) 
		echo "<div class='progress-group-header align-items-end' style='color: #777;'><div class='font-weight-bold mr-2'>Pedido: " . $row->tx_codigo . " (Encerrado)</div>";
  $percent = $row->medido_total / $row->nb_valor;
  $percent = $percent * 100;
  echo "<div class='ml-auto'>Progresso: (" . round($percent) ."%) - ";
  echo " R$" . (int)$row->medido_total . " / " . $row->nb_valor . "</div></div>";
  echo "<div class='progress-group-bars'> <div class='progress progress-xs'>";
  echo "<div class='progress-bar bg-success' role='progressbar' style='width: ".round($percent)."%' aria-valuenow='".round($percent)."' aria-valuemin='0' aria-valuemax='100'></div></div></div></div>";
}
}

?>


			</li>
		</ul>
		
		</div>
		<br>	
		<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, Bootstrap, then CoreUI  -->
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/@coreui/coreui@2.0.0-rc.1/dist/js/coreui.min.js"></script>

  </body>	
</body></html> 