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
    require("./controller/userclienteController.php");
    $cid = $_REQUEST["cid"];
    $cuid = $_REQUEST["cuid"];
		$data = getUserCliente($conn,$cuid);
		$pedidos = getCUPedidos($conn,$cuid);
  
?>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="central.php">Central</a></li>
			<li class="breadcrumb-item active"><a href="javascript:loadPhp('clientes.php');">Cadastro de Clientes</a></li>
			<li class="breadcrumb-item active"><a href="javascript:loadCData('<?php echo $cid ?>');">Detalhes do Cliente</a></li>
			<li class="breadcrumb-item active">Detalhes do Usuário Convidado</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class='card-header'><div class='row mt-1'><div class='col-7'>
						<h3>Dados do Usuário Convidado: </h3>
                        <h5><cite> <?php echo $data->tx_nome;?> </h5>
                        </div>
						<div class='col-5'>
                        
						<h3></h3>
						</div>
						</div>
					</div>	
					<div class="card-body">

    <form>	
    <div class='row'>
	<div class="form-group col-6">
		<label for="formNome">Nome: </label>
		<input style="text-transform: uppercase;" type="text" required  minlength="4" class="form-control" id="formNome" value="<?php echo $data->tx_nome;?>" name="Nome">
		<input type="text" class="form-control" value="<?php echo $cuid;?>" id="cuid" hidden>
		<label for="formEmail">E-Mail: </label>
		<input type="text" class="form-control" id="formEmail" name="Email" value="<?php echo $data->tx_email;?>" max-length="36" >
		<label for="formTel">Contato: </label>
		<input type="text" class="form-control" id="formTel" name="Tel" placeholder="(00)00000-0000" value="<?php echo $data->tx_contato;?>" max-length="16" >
	</div>
    </form>
        <div class="col-6">
				<h4><cite>Pedidos Relacionados:</h4>
<?php					
if(count($pedidos) != 0)	{			
echo"	<table class='table table-striped'>
		<thead>
			<tr>
				<th>Pedido</th>
				<th>Local</th>
				<th>Status</th>
				<th>Valor Medido</th>
				<th>Valor Total</th>
			</tr>
		</thead>
		<tbody>";


foreach($pedidos as $pedido){
		
	// Aloca os users e cria a list
	echo"<tr>
			<th><a class='btn btn-ghost-primary' href='javascript:atvPhp(".$pedido->id_pedido.");' role='button'>".$pedido->tx_codigo."</a></th>
			<th>".$pedido->tx_local."</th>";
			if($pedido->cs_estado == 0) echo"<th class='text-success text-center'>Ativo</th>";
			else echo"<th class='text-danger text-center'>Encerrado</th>";
			if($pedido->medido_total == null) echo"<th> R$ 0,00</th>";
			else echo"<th> R$ ".moeda($pedido->medido_total)."</th>";
			echo"<th class='text-primary'> R$ ".moeda($pedido->nb_valor)."</th>
		</tr>";	
	
	}	
echo"	</tbody>	</table>";
}
else{
	echo"<p class='text-center'><cite>Ainda não há pedidos relacionados à este usuário!</cite></p>";
}
	?>
        </div>   
     </div>
            <div class='row'>  
              <div class='col-6'>
			  <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modalRCuser'>Desativar Usuário Convidado</button>	
			  <button type='button' class='btn btn-primary float-right' value='1' id='updateButton'>Atualizar Usuário Convidado</button>		
              
              </div>
              <div class='col-6'>
              
              </div>
            </div> 
            <div class='row'>
            <div id="process"></div>
            </div>
        </div>
        </div>
    </div>


<!-- Modal Desativar Cliente User ------------------------->
<div class="modal" style="text-align: left" id="modalRCuser" tabindex="-1" role="dialog" aria-labelledby="modalRCuser" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalRCuser">Desativar Convidado <cite><?php echo$data->tx_nome;?></cite></h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
	<h4>Deseja desativar este usuário do sistema?</h4>
	<form>
	<input type="text" class="form-control" value="<?php echo $cid;?>" id="Cid" hidden>
	</form>
	<div class='row'>
		<div class='col-6'>
	
		</div>
		<div class='col-6'>
	<button type="button" class="btn btn-danger float-left" value="1" id="removeButton">Desativar</button>
	<button type="button" class="btn btn-primary float-right" data-dismiss="modal">Cancelar</button>
		</div>
			</div>
			  </div>
			    <div class="modal-footer">
					<div id="process"></div>
				</div>
				
			  </div>
			</div>
		  </div>