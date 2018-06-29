	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="central_ger.php">Central</a></li>
			<li class="breadcrumb-item active">Pedidos</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class='card-header'><div class="row mt-4"><div class="col-8 ">
						<h3>Pedidos: </h3>
							</div>
							<div class='col-4'>
							</div>
						</div>
					</div> 	
					<div class='row'>
						<div class='col-12'>	
					<div class="card-body">
						
						<h2> </h2>
<?php 
	session_start();
	require("./DB/conn.php");

//Carrrga as empresas pra colocar no titulo dos cards
$stmt0 = $conn->query("SELECT DISTINCT c.id_cliente,c.tx_nome,c.tx_cnpj FROM cliente AS c 
						INNER JOIN pedido AS p ON c.id_cliente = p.id_cliente
						WHERE p.id_usu_resp = ".$_SESSION['userid']." ORDER BY tx_nome ASC");

while($row0 = $stmt0->fetch(PDO::FETCH_OBJ)){
	$cliente = $row0->id_cliente;
	$cnpj = $row0->tx_cnpj;
	$clientecnpj = $row0->tx_nome." - CNPJ: ".$cnpj;
	$id=$row0->id_cliente;	
	echo"<div class='card-body' id='pedidoAccord'>
	<div class='accordion b-b-1' id='accordion'>
		<div class='card mb-0'>
		<div class='card-header' id='heading".$id."'>
			<h5 class='mb-0'>
				<button class='btn btn-outline-danger' type='button' data-toggle='collapse' data-target='#collapse".$id."' aria-expanded='true' aria-controls='collapse".$id."'>";					
	echo $clientecnpj;
	echo"</button>
			</h5>
				</div>
					<div id='collapse".$id."' class='collapse' aria-labelledby='heading".$id."' data-parent='#accordion'><div class='card-body'>";
	
		
	// Carrega os pedidos e coloca nos cards
	$stmt = $conn->query("SELECT c.id_cliente, p.tx_codigo, p.id_pedido, p.cs_estado, u.tx_name, v.medido_total, v.nb_valor FROM cliente As c 
							INNER JOIN pedido AS p ON c.id_cliente = p.id_cliente
							INNER JOIN usuario AS u ON p.id_usu_resp = u.id_usuario
							INNER JOIN v_sum_pedido_total AS v ON p.id_pedido = v.id_pedido
							WHERE c.id_cliente = " . $cliente . " AND p.id_usu_resp = ".$_SESSION['userid']." AND p.cs_estado = 0 ORDER BY p.tx_codigo ASC;");

	if($stmt->rowCount() == 0){
		echo"<p> Ainda não há pedidos disponíveis para gerenciamento. </p>";}
	else{
	//	href='javascript:atvPhp(&#39;atividades.php&#39;);'	  
	
		while($row = $stmt->fetch(PDO::FETCH_OBJ)){
			$percent = ($row->medido_total / $row->nb_valor) * 100;
			
		      echo "<div class='progress-group'>
					<div class='progress-group-header align-items-end' style='color: #27b;'><a class='btn btn-ghost-primary' href='javascript:atvPhp(".$row->id_pedido.");' role='button'><strong>Pedido: " . $row->tx_codigo . "</strong></a>"; 
			  echo "<div class='btn ml-auto'>Progresso: (" . round($percent) ."%)</div></div>";
			  echo "<div class='progress-group-bars'> <div class='progress progress-lg'>";
			  echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: ".round($percent)."%' aria-valuenow='".round($percent)."' aria-valuemin='0' aria-valuemax='100'>".round($percent)."%</div>
			  </div>
			  </div>
		</div>";
		}
	}
	echo"</div></div></div></div></div>";
}
$stmt = null;
$stmt0 = null;
?>
</div>