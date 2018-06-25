	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="central.php">Central</a></li>
			<li class="breadcrumb-item active">Pedidos por Cliente</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class='card-header'><div class="row mt-4"><div class="col-8 ">
						<h3>Pedidos por Cliente: </h3>
							</div>
							<div class='col-4'>
							<button type='button' class='btn btn-outline-primary float-right m-1' data-toggle='modal' data-target='#modalCliente'>+ Novo Cliente</button>
							<a class="btn btn-outline-success float-right m-1" href="javascript:loadPhp('pedidos.php');" role="button">Atualizar</a>
							</div>
						</div>
					</div> 	
					<div class='row'>
						<div class='col-12'>	
					<div class="card-body">
						
						<h2> </h2>
<?php 
	require("./DB/conn.php");

//Carrrga as empresas pra colocar no titulo dos cards
$stmt0 = $conn->query("SELECT id_cliente,tx_nome,tx_cnpj FROM cliente ORDER BY tx_nome ASC");

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
				<button type='button' class='btn btn-outline-primary float-right ml-3' data-toggle='modal' data-target='#modalPedido' data-cliente='".$clientecnpj."' data-id_cliente=".$row0->id_cliente.">+ Adicionar Pedido</button>
			</h5>
				</div>
					<div id='collapse".$id."' class='collapse' aria-labelledby='heading".$id."' data-parent='#accordion'><div class='card-body'>";
	
		
	// Carrega os pedidos e coloca nos cards
	$stmt = $conn->query("SELECT c.id_cliente, p.tx_codigo, p.id_pedido, p.cs_estado, u.tx_name, v.medido_total, v.nb_valor FROM cliente As c 
							INNER JOIN pedido AS p ON c.id_cliente = p.id_cliente
							INNER JOIN usuario AS u ON p.id_usu_resp = u.id_usuario
							INNER JOIN v_sum_pedido_total AS v ON p.id_pedido = v.id_pedido
							WHERE c.id_cliente = " . $cliente . " ORDER BY p.tx_codigo ASC;");

	if($stmt->rowCount() == 0){
		echo"<p> Não há pedidos cadastrados para este cliente! </p>";}
	else{
	//	href='javascript:atvPhp(&#39;atividades.php&#39;);'	  
	
		while($row = $stmt->fetch(PDO::FETCH_OBJ)){
			
			echo "<div class='progress-group'>";
			  if($row->cs_estado == 0) 
					echo "<div class='progress-group-header align-items-end' style='color: #27b;'><div><a class='btn btn-ghost-primary' href='javascript:atvPhp(".$row->id_pedido.");' role='button'><strong>Pedido: " . $row->tx_codigo . " (Ativo)</strong></a></div>";
			  if($row->cs_estado == 1) 
					echo "<div class='progress-group-header align-items-end' style='color: #777;'><div><a class='btn btn-ghost-secondary' href='javascript:atvPhp(".$row->id_pedido.");' role='button'><strong>Pedido: " . $row->tx_codigo . " (Encerrado)</strong></a></div>";
			  $percent = ($row->medido_total / $row->nb_valor) * 100;
			  echo "<div class='ml-auto'>Progresso: (" . round($percent) ."%) - ";
			  echo " R$" . $row->medido_total . " / " . $row->nb_valor . "</div></div>";
			  echo "<div class='progress-group-bars'> <div class='progress progress-lg'>";
			  echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: ".round($percent)."%' aria-valuenow='".round($percent)."' aria-valuemin='0' aria-valuemax='100'>".round($percent)."%</div>
			  </div>
			  </div>
			<p class='mb-0 mt-1 ml-2'><cite> Responsável: ".$row->tx_name."</cite></p>  
		</div>";
		}
	}
	echo"</div></div></div></div></div>";
}
$stmt = null;
$stmt0 = null;
?>
</div>

<!-- Modal Novo Cliente  -->
<div class="modal" style="text-align: left" id="modalCliente" tabindex="-1" role="dialog" aria-labelledby="modalCliente" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalCliente">Novo Cliente</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h4>
								<form>
    <div class="form-row">			
	  <div class="form-group col-md-12">
		<label for="formCliente">Razão Social: </label>
		<input style="text-transform: uppercase;" type="text" class="form-control" id="formCliente" placeholder="Razação Social" name="Cliente">
	  </div>
	</div>
	<div class="form-row">		
	  <div class="form-group col-md-12">
		<label for="formCNPJ">CNPJ: <h6><p class="text-muted"><cite> Somente Números</cite></p></h6></label>
		<input type="text" class="form-control" id="formCNPJ" name="CNPJ" placeholder="00.000.000/0000-0" max-length="17" >
	  </div>
	</div> 
	
	<a class='btn btn-primary float-right' href="javascript:formProc();" role='button'>Cadastrar</a>
			</h4></form><div id="process"></div>
			  </div>
			    <div class="modal-footer">
				
				</div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			  </div>
			</div>
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
		<input type="date" class="form-control" id="formDataA" name="iData" value="<?php echo date('Y-m-d');?>">
	  </div>
	  <div class="form-group col-3">
		<label for="formDataB">Término:</label>
		<input type="date" class="form-control" id="formDataB" name="tData" value="<?php echo date('Y-m-d');?>">
	  </div>
	</div>
	
	<div class="form-row">
	    <div class="form-group col-8">
			<label for="formVPedido">Valor do Pedido:</label>
			<input type="text" class="form-control" id="formVPedido" placeholder="0.00" name="valorPedido">
	    </div>
		 
		<div class="form-group col-4">	
			<div class="form-group">
				<label for="formRetencao">Retenção:</label>
				<select class="form-control" id="formRetencao" name="Retencao">
					<option value='5'>5%</option>
					<option value='10'>10%</option>
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
			<input type="text" style="text-transform: uppercase;" class="form-control" id="formLocal" name="Local" placeholder="Local das Atividades">
		  </div>
	</div>
	<div class="form-row">
	<div class="form-group col-12">
		<div class="form-group">
		<label for="formRespons">Responsável:</label>
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
	<div class="form-group">
		<label for="formControlTextarea">Informações Relacionadas:</label>
		<textarea class="form-control" id="formControlTextarea" rows="3" name="pdDescricao"></textarea>
    </div>
	
	<a class='btn btn-primary float-right' href="javascript:formProc();" role='button'>Adicionar</a>
			</h4></form><div id="process"></div>
			  </div>
			    <div class="modal-footer">
				
				</div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			  </div>
			</div>
		  </div>