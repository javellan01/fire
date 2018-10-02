	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="central.php">Central</a></li>
			<li class="breadcrumb-item active">Cadastro de Usuários</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class='card-header'><div class='row mt-1'><div class='col-10'>
						<h3> Lista Geral de Usuários: </h3></div>
						<div class='col-2'>
						<button type='button' class='btn btn-outline-primary float-right m-1' data-toggle='modal' data-target='#modalCUsr'>+ Novo Convidado</button>
						</div>
						</div>
					</div>	
					<div class="card-body">
	
	<h4><cite> Usuários Convidados: </h4>
	<table class='table table-responsive-xl table-striped'>
		<thead>
			<tr>
				<th>Nome</th>
				<th>Contato</th>
				<th>Email</th>
				<th>Cliente</th>
				<th>Acesso</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<?php	
	require("./DB/conn.php");
	
	function time_usql($data) {
		$ndata = substr($data, 8, 2) ."/". substr($data, 5, 2) ."/".substr($data, 0, 4).substr($data, 10, 9);
		return $ndata;
	}
	
	$stmt0 = $conn->query("SELECT cu.*, CONVERT_TZ(cu.last_access,'+00:00','-04:00') AS tz_last, c.tx_nome AS cnome FROM cliente_usr AS cu INNER JOIN cliente AS c ON cu.id_cliente = c.id_cliente ORDER BY cnome ASC");

while($row0 = $stmt0->fetch(PDO::FETCH_OBJ)){
	$id = $row0->id_usuario;
	$tel = $row0->tx_contato;
	
	// Aloca os users e cria a list
	echo"<tr id='uid100$id'>
			<th class='uname'>".$row0->tx_nome."</th>
			<th class='utel'>$tel</th>
			<th class='umail'>".$row0->tx_email."</th>
			<th class='ucliente'>".$row0->cnome."</th>
			<th class='uacesso'>".time_usql($row0->tz_last)."</th>
			<th><button type='button' class='btn btn-outline-primary float-right ml-3' data-toggle='modal' data-target='#modalEdCUsr' data-uid='$id'>Editar</button></th>
		</tr>";	
	
	}	
$stmt = null;
$stmt0 = null;
?>
		</tbody>
	</table>
	</div>
	</div>
</div>

<!-- Modal Novo Usuário  -->
<div class="modal" style="text-align: left" id="modalCUsr" tabindex="-1" role="dialog" aria-labelledby="modalCUsr" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalCUsr">Novo Usuário Convidado</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h4>
								<form>
    <div class="form-row">			
	  <div class="form-group col-12">
		<label for="formCUser">Nome: </label>
		<input style="text-transform: uppercase;" type="text" class="form-control" id="formCUser" placeholder="" name="CUsuario">
	  </div>
	</div>
	<div class="form-row">		
	  <div class="form-group col-12">
		<label for="formCEmail">E-mail: </label>
		<input type="text" class="form-control" id="formCEmail" name="CEmail">
	  </div>
	</div> 
	<div class="form-row">		
	  <div class="form-group col-7">
		
		<label for="formCTel">Contato: </label>
		<input type="text" class="form-control" id="formCTel" name="CTelefone" placeholder="(00) 00000-0000" max-length="16" >
	  </div>
	  <div class="form-group col-5">	
			<div class="form-group">
				<label for="formCliente">Cliente: </label>
				<select class="form-control" id="formCliente" name="Cliente">
				<option selected hidden>Selecionar Cliente</option>
			<?php 	$stmt = $conn->query("SELECT id_cliente, tx_nome FROM cliente ORDER BY tx_nome ASC");
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){ 
			  echo "<option value=".$row->id_cliente.">".$row->tx_nome."</option>";
			}
			  ?> 
			 </div>
		</div> 
	</div> 
	</select>
	<a class='btn btn-primary float-right' href="javascript:formProc();" role='button'>Cadastrar</a>
			</h4></form><div id="process"></div>
			  </div>
			    <div class="modal-footer">
				
				</div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			  </div>
			</div>
		  </div>
	
<!-- Modal Editar Usuário  -->		  
		  <div class="modal" style="text-align: left" id="modalEdUsr" tabindex="-1" role="dialog" aria-labelledby="modalEdUsr" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalEdUsr">Editar Usuário</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h4>
								<form>
    <div class="form-row">			
	  <div class="form-group col-12">
		<label for="formUser">Nome: </label>
		<input style="text-transform: uppercase;" type="text" class="form-control" id="formUser" value="" name="editUsuario">
		<input type="text" class="form-control" id="formUserid" value="" name="editUserid" hidden>
	  </div>
	</div>
	<div class="form-row">		
	  <div class="form-group col-8">
		<label for="formCPF">CPF:<span class='text-danger'>*</span></label>
		<input type="text" class="form-control" id="formCPF" name="editCPF" placeholder="000.000.000-00" max-length="14" >
	  </div>
	  <div class="form-group col-4">	
			<div class="form-group">
				<label for="formECatuser">Tipo: </label>
				<select class="form-control" id="formECatuser" name="editCatuser">
					<option value='0'>Administrador</option>
					<option value='1'>Gerente</option>
					<option value='2'>Base</option>
					<option value='3'>Convidado</option>
				</select>  
			 </div>
		</div> 
	</div> 
	<div class="form-row">		
	  <div class="form-group col-6">
		<label for="formEmail">E-mail: </label>
		<input type="text" class="form-control" id="formEmail" name="editEmail">
	  </div>
	  <div class="form-group col-6">
		<label for="formTel">Contato: </label>
		<input type="text" class="form-control" id="formTel" name="editTelefone" placeholder="(00) 0.0000-0000" max-length="16" >
	  </div>
	</div> 
	<a class='btn btn-primary float-right' href="javascript:formProc();" role='button'>Atualizar</a>
			</h4></form><div id="process"></div>
			  </div>
			    <div class="modal-footer">
				
				</div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			  </div>
			</div>
		  </div>

