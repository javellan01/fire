<?php 
	// Inicia sessões
	session_start(); 
	//echo session_status(); 
	// Verifica se existe os dados da sessão de login 
	if(!isset($_SESSION["login"]) || !isset($_SESSION["usuario"])) 
		{ 
	// Usuário não logado! Redireciona para a página de login 
		header("Location: login.php"); 
		exit; 
	} 

	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: 0"); //
?>

	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="central.php">Central</a></li>
			<li class="breadcrumb-item active">Cadastro de Clientes</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class='card-header'><div class='row mt-1'><div class='col-10'>
						<h3> Lista Geral de Clientes: </h3></div>
						<div class='col-2'>
						<button type='button' class='btn btn-outline-primary float-right m-1' data-toggle='modal' data-target='#modalNCliente'>+ Novo Cliente</button>
						</div>
						</div>
					</div>	
					<div class="card-body">
	
	<h4><cite>Clientes Cadastrados: </h4>
	<table class='table table-responsive-xl table-striped'>
		<thead>
			<tr>
				<th>Razão Social</th>
				<th>CNPJ</th>
				<th>Pedidos Ativos</th>
				<th>Pedidos Totais</th>
				<th>Usuários Cadastrados</th>
			</tr>
		</thead>
		<tbody>
<?php	
	require("./DB/conn.php");
	require("./controller/clientesController.php");

$data = getClientes($conn);
foreach($data as $cliente){
	$cid = $cliente->id_cliente;
	$pnb = 0;
	$pnbt = 0;
	foreach(getPedidosCliente($conn,$cid) as $pedido){
		if($pedido->cs_estado == 0) $pnb += 1;
		$pnbt += 1;
	}
	$cunb = getUserCliente($conn,$cid);
	$cunb = count($cunb);
	// Aloca os users e cria a list e todos o modais
	echo"<tr>
			<th><a class='btn btn-ghost-primary' href='javascript:loadCData(".$cid.");' role='button'>".$cliente->tx_nome."</a></th>
			<th>".$cliente->tx_cnpj."</th>
			<th>".$pnb."</th>
			<th>".$pnbt."</th>";
			if($cunb == 0) echo "<th>Favor Cadastrar Usuário</th>";
			else echo "<th>".$cunb."</th>";
      
	echo" </tr>";	
	
	}	

?>
		</tbody>
	</table>
	</div>
	</div>
</div>

<!-- Modal Novo Cliente  -->
<div class="modal" style="text-align: left" id="modalNCliente" tabindex="-1" role="dialog" aria-labelledby="modalNCliente" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalNCliente">Novo Cliente</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h4>
								<form>
    <div class="form-row">			
	  <div class="form-group col-md-12">
		<label for="formCliente">Razão Social: </label>
		<input style="text-transform: uppercase;" type="text" required class="form-control" id="formCliente" placeholder="Razação Social" name="Cliente">
	  </div>
	</div>
	<div class="form-row">		
	  <div class="form-group col-md-12">
		<label for="formCNPJ">CNPJ: <h6><p class="text-muted"><cite> Somente Números</cite></p></h6></label>
		<input type="text" required  minlength="18" class="form-control" id="formCNPJ" name="CNPJ" placeholder="00.000.000/0000-0">
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
		