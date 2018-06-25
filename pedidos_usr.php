	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="javascript:loadPhp('central.php');">Central</a></li>
			<li class="breadcrumb-item active">Pedidos por Cliente</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class='card-header'><div class="row mt-4"><div class="col-10 ">
						<h3>Pedidos por Cliente: </h3>
							</div>
							<div class='col-2'>
							
							</div>
						</div>
					</div> 	
					<div class='row'>
						<div class='col-12'>
					<div class="card-body">
						<h2> </h2>
<?php 
	require('.DB/conn.php');

//Carrrga as empresas pra colocar no titulo dos cards
$stmt0 = $conn->query("SELECT id_cliente,tx_nome,tx_cnpj FROM cliente ORDER BY tx_nome ASC");

while($row0 = $stmt0->fetch(PDO::FETCH_OBJ)){
	$cliente = $row0->id_cliente;
	$cnpj = substr($row0->tx_cnpj, 0, 2) . "." .substr($row0->tx_cnpj, 2, 3) .".".substr($row0->tx_cnpj, 5, 3)."/".substr($row0->tx_cnpj, 8, 4)."-".substr($row0->tx_cnpj, 12, 2);
	$id=$row0->id_cliente;	
	echo"<div class='card-body' id='pedidoAccord'>
	<div class='accordion b-b-1' id='accordion'>
		<div class='card mb-0'>
		<div class='card-header' id='heading".$id."'>
			<h5 class='mb-0'>
				<button class='btn btn-outline-danger' type='button' data-toggle='collapse' data-target='#collapse".$id."' aria-expanded='true' aria-controls='collapse".$id."'>";					
	echo $row0->tx_nome." - CNPJ: ".$cnpj;
	echo"</button>
				
			</h5>
				</div>
					<div id='collapse".$id."' class='collapse' aria-labelledby='heading".$id."' data-parent='#accordion'><div class='card-body'>";
	
		
	// Carrega os pedidos e coloca nos cards
	$stmt = $conn->query("SELECT c.id_cliente, p.tx_codigo, p.id_pedido, p.cs_estado, v.medido_total, v.nb_valor FROM cliente As c 
							INNER JOIN pedido AS p ON c.id_cliente = p.id_cliente
							INNER JOIN v_sum_pedido_total AS v ON p.id_pedido = v.id_pedido
							WHERE c.id_cliente = " . $cliente . " ORDER BY p.tx_codigo ASC;");

	if($stmt->rowCount() == 0){
		echo"<p> Não há pedidos cadastrados para este cliente! </p>";}
	else{
	//	href='javascript:atvPhp(&#39;atividades.php&#39;);'	  
	
		while($row = $stmt->fetch(PDO::FETCH_OBJ)){
			
			echo "<div class='progress-group'>";
			  if($row->cs_estado == 0) 
					echo "<div class='progress-group-header align-items-end' style='color: #27b;'><div><a class='btn btn-ghost-primary' href='javascript:atv_uPhp(".$row->id_pedido.");' role='button'><strong>Pedido: " . $row->tx_codigo . " (Ativo)</strong></a></div>";
			  if($row->cs_estado == 1) 
					echo "<div class='progress-group-header align-items-end' style='color: #777;'><div><a class='btn btn-ghost-secondary' href='javascript:atv_uPhp(".$row->id_pedido.");' role='button'><strong>Pedido: " . $row->tx_codigo . " (Encerrado)</strong></a></div>";
			  $percent = ($row->medido_total / $row->nb_valor) * 100;
			  echo "<div class='ml-auto'>Progresso: (" . round($percent) ."%) - ";
			  echo " R$" . $row->medido_total . " / " . $row->nb_valor . "</div></div>";
			  echo "<div class='progress-group-bars'> <div class='progress progress-md'>";
			  echo "<div class='progress-bar progress-bar-stripped bg-success' role='progressbar' style='width: ".round($percent)."%' aria-valuenow='".round($percent)."' aria-valuemin='0' aria-valuemax='100'></div></div></div></div>";
		}
	}
	echo"</div></div></div></div></div>";
}
$stmt = null;
$stmt0 = null;
?>
</div>