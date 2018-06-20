	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="javascript:loadPhp('central.php');">Central</a></li>
			<li class="breadcrumb-item active">Cadastro de Usuários</li>
		</ol>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 ">
				<div class="card">
					<div class="card-body">
						<button type='button' class='btn btn-outline-primary float-right ml-3' data-toggle='modal' data-target='#modalUsr'>+ Novo Usuário</button>
						<h2>Pedidos por Cliente: </h2>
<?php 
	require('conn.php');

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
				<button type='button' class='btn btn-outline-primary float-right ml-3' data-toggle='modal' data-target='#modalUsr'>+ Adicionar Pedido</button>
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
					echo "<div class='progress-group-header align-items-end' style='color: #27b;'><div><a class='btn btn-ghost-primary' href='javascript:atvPhp(".$row->id_pedido.");' role='button'><strong>Pedido: " . $row->tx_codigo . " (Ativo)</strong></a></div>";
			  if($row->cs_estado == 1) 
					echo "<div class='progress-group-header align-items-end' style='color: #777;'><div><a class='btn btn-ghost-secondary' href='javascript:atvPhp(".$row->id_pedido.");' role='button'><strong>Pedido: " . $row->tx_codigo . " (Encerrado)</strong></a></div>";
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

<!-- Modal Novo Usuário  -->
<div class="modal" style="text-align: left" id="modalUsr" tabindex="-1" role="dialog" aria-labelledby="modalUsr" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalUsr">Novo Usu</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h4>
								<form>
    <div class="form-row">			
	  <div class="form-group col-12">
		<label for="formCliente">Nome: </label>
		<input style="text-transform: uppercase;" type="text" class="form-control" id="formCliente" placeholder="" name="Usuario">
	  </div>
	</div>
	<div class="form-row">		
	  <div class="form-group col-8">
		<label for="formCPF">CPF: <p class='text-danger'>*</p><h6><p class="text-muted"><cite> Somente Números</cite></p></h6></label>
		<input type="text" class="form-control" id="formCPF" name="CPF" placeholder="000.000.000-00" max-length="11" >
	  </div>
	  <div class="form-group col-4">	
			<div class="form-group">
				<label for="formCatuser">Tipo:</label>
				<select class="form-control" id="formCatuser" name="Catuser">
					<option value='0'>Administrador</option>
					<option selected value='1'>Normal</option>
				</select>  
			 </div>
		</div> 
	</div> 
	<div class="form-row">		
	  <div class="form-group col-12">
		<label for="formEmail">CPF: <p class='text-danger'>*</p><h6><p class="text-muted"><cite> Somente Números</cite></p></h6></label>
		<input type="text" class="form-control" id="formEmail" name="Email" placeholder="000.000.000-00" max-length="11" >
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
	  <div class="form-group col-8">
		<label for="formPedido">Código Pedido:</label>
		<input style="text-transform: uppercase;" type="text" class="form-control" id="formPedido" placeholder="PEDIDO OU CONTRATO" name="Pedido">
	  </div>
	  <div class="form-group col-4">
		<label for="formData">Data:</label>
		<input type="date" class="form-control" id="formData" name="iData" value="<?php echo date('Y-m-d');?>">
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
				<label for="formSCliente">Cliente:</label>
				<select class="form-control" id="formSCliente" name="sCliente">
				<option selected hidden>Selecionar Empresa</option>
		  <?php 	$stmt4 = $conn->query("SELECT id_cliente, tx_nome FROM cliente ORDER BY tx_nome ASC");
				while($row4 = $stmt4->fetch(PDO::FETCH_OBJ)){ 
				  echo "<option value=".$row4->id_cliente.">".$row4->tx_nome."</option>";
				}
				  ?>
				</select>  
			</div>
		</div>
		<div class="form-group col-6">
			<label for="formLocal">Data:</label>
			<input type="text" style="text-transform: uppercase;" class="form-control" id="formLocal" name="Local" placeholder="Local das Atividades">
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
<script>
		$(document).ready(function(){ 
		  $('#formCNPJ').mask('00.000.000/0000-00', {reverse: true});
		});
		$("#fecharBtn").click(function(){
			$("#pedidoAccord").load("pedidos.php #pedidoAccord");
		});
</script>