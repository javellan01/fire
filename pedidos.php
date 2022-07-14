<style>
      .btn {
        white-space: normal;
      }
</style>
<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="central.php">Central</a></li>
			<li class="breadcrumb-item active">Pedidos por Cliente</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class='card-header'><div class="row mt-1"><div class="col-8 ">
						<h3><i class="nav-icon cui-list"></i> Pedidos por Cliente: </h3>
							</div>
							<div class='col-4'>
							<button type='button' class='btn btn-outline-primary float-right m-1' data-toggle='modal' data-target='#modalCliente'>+ Novo Cliente</button>
							</div>
						</div>
					</div> 	
					<div class='row'>
						<div class='col-12'>	
					<div class="card-body">
<?php 
	require("./DB/conn.php");
	session_start();
	require("./controller/agentController.php");
	Auth::accessControl($_SESSION['catuser'],0);
	require("./controller/pedidosController.php");

//Carrega as empresas(clientes) pra colocar no titulo dos cards
$clientes = getClientes($conn);

if(!$clientes){
	echo"<p><i class='nav-icon cui-info'></i> Ainda não há clientes cadastrados no sistema. </p>";}

foreach($clientes as $cliente){
			
	echo"<div class='card-body' id='pedidoAccord'>
	<div class='accordion b-b-1 shadow rounded' id='accordion'>
		<div class='card mb-0'>
		<div class='card-header' id='heading".$cliente->id_cliente."'>
			<h5 class='mb-0'>
				<button class='btn btn-outline-danger' type='button' data-toggle='collapse' data-target='#collapse".$cliente->id_cliente."' aria-expanded='true' aria-controls='collapse".$cliente->id_cliente."'>";					
	echo $cliente->tx_nome." - CNPJ: ".$cliente->tx_cnpj;
	echo" <i class='nav-icon cui-chevron-bottom'></i></button>
				<button type='button' class='btn btn-outline-primary float-right ml-3' data-toggle='modal' data-target='#modalPedido' data-cliente='".$cliente->tx_nome." - CNPJ: ".$cliente->tx_cnpj."' data-id_cliente=".$cliente->id_cliente.">+ Adicionar Pedido</button>
			</h5>
				</div>
					<div id='collapse".$cliente->id_cliente."' class='collapse show' aria-labelledby='heading".$cliente->id_cliente."' data-parent='#accordion'><div class='card-body'>";
		
	// Carrega os pedidos e coloca nos cards
	$pedidos = getPedidosCliente($conn,$cliente->id_cliente);

	if(!$pedidos){
		echo"<p><i class='nav-icon cui-info'></i> Não há pedidos cadastrados para este cliente! </p>";}
	else{		
		foreach($pedidos as $pedido){
		$fisico = getProgressoFisico($conn,$pedido->id_pedido);
		if(!$fisico){
			$percent_fisico = 0;
		}  
		else {
			$percent_fisico = $fisico->execpercent;
		}

		echo "<div class='progress-group'>";
			if($pedido->cs_estado == 0) 
			echo "<div class='progress-group-header align-items-end' style='color: #27b;'><div><a class='btn btn-ghost-primary' href='javascript:atvPhp(".$pedido->id_pedido.");' role='button'><strong>Pedido: " . $pedido->tx_codigo . " (Ativo) <i class='nav-icon cui-chevron-right'></i></strong></a></div>";
			if($pedido->cs_estado == 1) 
			echo "<div class='progress-group-header align-items-end' style='color: #777;'><div><a class='btn btn-ghost-secondary' href='javascript:atvPhp(".$pedido->id_pedido.");' role='button'><strong>Pedido: " . $pedido->tx_codigo . " (Encerrado) <i class='nav-icon cui-chevron-right'></i></strong></a></div>";

			echo "<div class='ml-auto'>Atividades Concluídas: " . $percent_fisico ."%</div></div>";
			echo "<div class='progress-group-bars'> <div class='progress progress-lg'>";
			echo "<div class='progress-bar progress-bar-striped bg-warning' role='progressbar' style='width: ". $percent_fisico ."%' aria-valuenow='". $percent_fisico ."' aria-valuemin='0' aria-valuemax='100'>". $percent_fisico ."%</div></div>";

			if($pedido->nb_valor != 0.00){
				$percent = ($pedido->medido_total / $pedido->nb_valor) * 100;
			}
			else
			$percent = 0.00;
			echo "<div class='ml-auto'>Progresso Financeiro: (" . round($percent) ."%) - ";
			echo " R$" . moeda($pedido->medido_total) . " / " . moeda($pedido->nb_valor) . "</div></div>";
			echo "<div class='progress-group-bars'> <div class='progress progress-lg'>";
			echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: ".round($percent)."%' aria-valuenow='".round($percent)."' aria-valuemin='0' aria-valuemax='100'>".round($percent)."%</div>
			</div>
			<div class='ml-auto'><cite>Responsável: ".$pedido->tx_name."</cite></div>
			</div>
			
		  
		</div>";
		}
	}
	echo"</div></div></div></div></div>";
}

?>
</div>


		  
<!-- Modal Novo Pedido  -->
<div class="modal" style="text-align: left" id="modalPedido" tabindex="-1" role="dialog" aria-labelledby="modalPedido" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalPedido">Novo Pedido</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h4>
								<form>
    <div class="form-row">			
	  <div class="form-group col-6">
		<label for="formPedido">Código Pedido:</label>
		<input style="text-transform: uppercase;" type="text" class="form-control" id="formPedido" placeholder="PEDIDO OU CONTRATO" name="Pedido">
	  </div>
	  <div class="form-group col-3">
		<label for="formDataA">Ínicio:</label>
		<input type="text" class="form-control date" id="formDataA" name="iData" value="<?php echo date('d/m/Y');?>">
	  </div>
	  <div class="form-group col-3">
		<label for="formDataB">Término:</label>
		<input type="text" class="form-control date" id="formDataB" name="tData" value="<?php echo date('d/m/Y');?>">
	  </div>
	</div>
	
	<div class="form-row">
	    <div class="form-group col-8">
			<label for="formValor">Valor do Pedido:</label>
			<input type="text" class="form-control" id="formValor" placeholder="0.00" name="valorPedido">
	    </div>
		 
		<div class="form-group col-4">	
			<div class="form-group">
				<label for="formRetencao">Retenção:</label>
				<select class="form-control" id="formRetencao" name="Retencao">
					<option selected value='5'>5%</option>
					<option value='10'>10%</option>
					<option value='15'>15%</option>
					<option value='20'>20%</option>
				</select>  
			 </div>
		</div> 
	</div>
	
	<div class="form-row">
		<div class="form-group col-6">	
			<div class="form-group">
				<label for="formSCliente">Cliente: </label>
				<input type="text" class="form-control" id="formSCliente" name="SCliente" value="" disabled>
				<input type="text" class="form-control d-none" id="formidCliente" name="idCliente">
			</div>
		</div>
		<div class="form-group col-6">
			<label for="formLocal">Local: </label>
			<input type="text" style="" class="form-control" id="formLocal" name="Local" placeholder="Local das Atividades">
		  </div>
	</div>
	<div class="form-row">
	<div class="form-group col-12">
		<div class="form-group">
		<label for="formRespons">Responsável FireSystems:</label>
			<select class="form-control" id="formRespons" name="Responsavel">
			<option selected hidden>Selecionar Responsável</option>
	<?php 	$stmt = $conn->query("SELECT * FROM usuario ORDER BY id_usuario ASC");
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){ 
			  echo "<option value=".$row->id_usuario.">".$row->tx_name."</option>";
			}
			  ?>
			</select> 
		</div>
	</div>
	</div>
	<div class="form-row">
	<div class="form-group col-12">
		<div class="form-group">
		<label for="formRespons">Responsável no Cliente:</label>
			<select class="form-control" id="formRepresentante" name="Representante">
			<option selected hidden>Selecionar Representante</option>
	<?php 	$stmt = $conn->query("SELECT tx_nome, id_cliente, id_usuario FROM cliente_usr ORDER BY id_usuario ASC");
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){ 
			  echo "<option value=".$row->id_usuario.">".$row->tx_nome."</option>";
			}
			  ?>
			</select> 
		</div>
	</div>
	</div>	
	<div class="form-group">
		<label for="formControlTextarea">Informações Relacionadas:</label>
		<textarea class="form-control" id="formControlTextarea" rows="3" name="pdDescricao"></textarea>
    </div>
	
	<a class='btn btn-primary float-right' href="javascript:formProc();" role='button'><i class='nav-icon cui-check'></i> Adicionar</a>
			</h4></form><div id="process"></div>
			  </div>
			    <div class="modal-footer">
				
				</div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='nav-icon cui-ban'></i> Fechar</button>
			  </div>
			</div>
		  </div>