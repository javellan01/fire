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

    require("./DB/conn.php");
    require("./controller/clientesController.php");
    
    $cid = $_REQUEST["cid"];
    $data = getCliente($conn,$cid);
		$cusers = getUserCliente($conn,$cid);
		$pedidos = getPedidosCliente($conn,$cid);
?>

	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="central.php">Central</a></li>
			<li class="breadcrumb-item active"><a href="javascript:loadPhp('clientes.php');">Cadastro de Clientes</a></li>
			<li class="breadcrumb-item active">Detalhes do Cliente</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class='card-header'><div class='row mt-1'><div class='col-8'>
						<h3> Dados do Cliente: </h3>
                        <h5><cite> <?php echo $data->tx_nome;?></cite> - <?php echo $data->tx_cnpj;?></h5>
                        </div>
						<div class='col-4'>    
						<button type='button' class='btn btn-outline-primary float-right m-1' data-toggle='modal' data-target='#modalNCUser'>+ Novo Usuário Convidado</button>
						</div>
						</div>
					</div>	
					<div class="card-body">

    <form>	
  <div class='row'>
		<div class="form-group col-5">
			<label for="formCNome">Razão Social:</label>
			<input style="text-transform: uppercase;" type="text" required  minlength="4" class="form-control" id="formCNome" value="<?php echo $data->tx_nome;?>" name="CNome">
			<input type="text" class="form-control" value="1" name="processMode" hidden>
			<input type="text" class="form-control" value="<?php echo $cid;?>" name="CId" hidden>
		</div>
		<div class="form-group col-4">
			<label for="formCNPJ">CNPJ: </label>
			<input type="text" require class="form-control" id="formCNPJ" name="CNPJ" value="<?php echo $data->tx_cnpj;?>" minlength="18" >
		</div>	
    </form>
			<div class='col-2'>
			<div class='mt-4'>
				<a class='btn btn-primary float-right' href="javascript:formFProc();" role='button'>Atualizar Cadastro</a>
			</div>		
			</div>
	</div>
<!------ LISTAGEM DE USUARIOS CONVIDADOS --------------------------------------->
  <div class="row m-auto">
	<h4><cite>Usuários Convidados: </h4>
	<table class='table table-responsive-xl table-striped'>
		<thead>
			<tr>
				<th>Nome</th>
				<th>Contato</th>
				<th>Email</th>
				<th>Pedidos Ativos</th>
				<th>Último Acesso</th>
			</tr>
		</thead>
		<tbody>
<?php	
	
foreach($cusers AS $user){
	$cuid = $user->id_usuario;
	
	// Aloca os users e cria a list
	echo"<tr id='cuid100$cuid'>

			<th><a class='btn btn-ghost-primary' href='javascript:loadUCData(".$cuid.",".$cid.");' role='button'>".$user->tx_nome."</a></th>
			<th>".$user->tx_contato."</th>
			<th>".$user->tx_email."</th>
			<th>".getUsrPedidosAtivos($conn,$cuid)."</th>
			<th>".time_usql($user->tz_last)."</th>
			</tr>";	
	
	}	
?>
		</tbody>
	</table>
</div>   
<!------ LISTAGEM DE PEDIDOS CADASTRADOS --------------------------------------->			        
<div class='row m-auto'>  
	<h4><cite>Pedidos Cadastrados:</h4>
	<table class='table table-responsive-xl table-striped'>
		<thead>
			<tr>
				<th>Código do Pedido</th>
				<th>Local</th>
				<th>Status</th>
				<th>Data Início</th>
				<th>Data Término</th>
				<th>Atividades Executadas</th>
				<th>Valor Medido</th>
				<th>Valor Total</th>
			</tr>
		</thead>
		<tbody>
<?php	
$sumatv = $summed = $sumtotal = 0.00;
foreach($pedidos as $pedido){
	$sumatv += $pedido->total_atividade;
	$summed += $pedido->medido_total;
	$sumtotal += $pedido->nb_valor;
	
	// Aloca os users e cria a list
	echo"<tr>
			<th><a class='btn btn-ghost-primary' href='javascript:atvPhp(".$pedido->id_pedido.");' role='button'>".$pedido->tx_codigo."</a></th>
			<th>".$pedido->tx_local."</th>";
			if($pedido->cs_estado == 0) echo"<th class='text-success'>Ativo</th>";
			else echo"<th class='text-danger'>Encerrado</th>";
			echo "<th>".data_usql($pedido->dt_idata)."</th>
			<th>".data_usql($pedido->dt_tdata)."</th>";
			if($pedido->total_atividade == null) echo"<th> R$ 0,00</th>";
			else echo"<th> R$ ".moeda($pedido->total_atividade)."</th>";
			if($pedido->medido_total == null) echo"<th> R$ 0,00</th>";
			else echo"<th> R$ ".moeda($pedido->medido_total)."</th>";
			echo"<th class='text-primary'> R$ ".moeda($pedido->nb_valor)."</th>
		</tr>";	
	
	}	
	echo"<tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
	<tr><th></th><th></th><th></th><th></th><th>Totais:</th><th>R$ ".moeda($sumatv)."</th><th>R$ ".moeda($summed)."</th><th>R$ ".moeda($sumtotal)."</th></tr>";


?>
		</tbody>
	</table>
            </div> 
            <div class='row'>
            <div id="process"></div>
            </div>
        </div>
        </div>
    </div>
<!-- Modal Novo Cliente Usuario  -->
<div class="modal" style="text-align: left" id="modalNCUser" tabindex="-1" role="dialog" aria-labelledby="modalNCUser" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalNCUser">Novo Usuário Convidao</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h4>
								<form id="user">
  <div class="form-row">			
	  <div class="form-group col-12">
		<label for="formNome">Nome: </label>
		<input style="text-transform: uppercase;" type="text" required  minlength="4" class="form-control" id="formNome" placeholder="" name="Nome">
		<input type="text" class="form-control" value="0" name="uprocessMode" hidden>
		<input type="text" class="form-control" value="<?php echo $cid;?>" name="cid" hidden>
	  </div>
		<div class="form-group col-6">
		<label for="formEmail">Email: </label>
		<input type="text" class="form-control" id="formEmail" name="Email" placeholder="nome@empresa.com" max-length="36" >
	  </div>
	</div>
	<div class="form-row">		
	  <div class="form-group col-7">
		<label for="formTel">Contato: </label>
		<input type="text" class="form-control" id="formFTel" name="Tel" placeholder="(00)00000-0000" max-length="16" >
	  </div>
	</div>

	<a class='btn btn-primary float-right' href="javascript:formCProc();" role='button'>Cadastrar</a>
			</h4></form><div id="process"></div>
			  </div>
			    <div class="modal-footer">
				
				</div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			  </div>
			</div>
		  </div>