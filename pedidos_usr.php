<style>
      .btn {
        white-space: normal;
      }
</style>	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="central_usr.php">Central</a></li>
			<li class="breadcrumb-item active">Pedidos</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class='card-header'><div class="row mt-1"><div class="col-8 ">
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
	require("./controller/agentController.php");
	Auth::accessControl($_SESSION['catuser'],2);
	require("./DB/conn.php");
	require("./controller/pedidosController.php");
	
//Carrrga as empresas pra colocar no titulo dos cards
$clientes = getUserClientes($conn,$_SESSION['userid']);

if(count($clientes) == 0){
	echo"<p class='h4'> Ainda não há pedidos disponíveis para visualizar.</p>";}
else{
	foreach($clientes as $cliente){

	echo"<div class='card-body' id='pedidoAccord'>
	<div class='accordion b-b-1' id='accordion'>
		<div class='card mb-0'>
		<div class='card-header' id='heading".$cliente->id_cliente."'>
			<h5 class='mb-0'>
				<button class='btn btn-outline-danger' type='button' data-toggle='collapse' data-target='#collapse".$cliente->id_cliente."' aria-expanded='true' aria-controls='collapse".$cliente->id_cliente."'>";					
	echo $cliente->tx_nome;
	echo" <i class='nav-icon cui-chevron-bottom'></i></button>
			</h5>
				</div>
					<div id='collapse".$cliente->id_cliente."' class='collapse show' aria-labelledby='heading".$cliente->id_cliente."' data-parent='#accordion'><div class='card-body'>";
	
		
	// Carrega os pedidos e coloca nos cards
	$pedidos = getUserPedidos($conn,$_SESSION['userid']);

	if(count($pedidos) == 0){
		echo"<p class='h4'> Ainda não há pedidos disponíveis para visualizar neste cliente.</p>";}
	else{
	foreach($pedidos as $pedido){
		$fisico = getProgressoFisico($conn,$pedido->id_pedido);	
		      echo "<div class='progress-group'>
					<div class='progress-group-header align-items-end' style='color: #27b;'><a class='btn btn-ghost-primary' href='javascript:atv_uPhp(".$pedido->id_pedido.");' role='button'><strong>Pedido: " . $pedido->tx_codigo . " <i class='nav-icon cui-chevron-right'></i></strong></a>"; 
			  echo "<div class='btn ml-auto'>Atividades Concluídas: (" . $fisico->execpercent ."%)</div></div>";
			  echo "<div class='progress-group-bars'> <div class='progress progress-lg'>";
			  echo "<div class='progress-bar progress-bar-striped bg-warning' role='progressbar' style='width: ".$fisico->execpercent ."%' aria-valuenow='".$fisico->execpercent."' aria-valuemin='0' aria-valuemax='100'>".$fisico->execpercent."%</div>
			  </div>
			  </div>
		</div>";
		}
	}
	echo"</div></div></div></div></div>";
	}
}

?>
</div>