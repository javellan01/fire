	
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
						<button type='button' class='btn btn-outline-primary float-right m-1' data-toggle='modal' data-target='#modalUsr'>+ Novo Usuário</button>
						</div>
						</div>
					</div>	
					<div class="card-body">
	<h4><cite> Usuários FireSystems: </h4>					
	<table class='table table-striped'>
		<thead>
			<tr>
				<th>Nome</th>
				<th>Contato</th>
				<th>Email</th>
				<th>CPF</th>
				<th>Categoria</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

<?php 
	session_start(); 
	require("./controller/agentController.php");
	Auth::accessControl($_SESSION['catuser'],0);
	require("./DB/conn.php");

//Carrrga as users pra colocar na lista
$stmt0 = $conn->query("SELECT * FROM usuario ORDER BY id_usuario ASC");

while($row0 = $stmt0->fetch(PDO::FETCH_OBJ)){
	$id = $row0->id_usuario;
	$cpf = $row0->tx_cpf;
	$tel = $row0->tx_telefone;
	$catuser = $row0->nb_category_user;
	
	
	// Aloca os users e cria a list
	
	if($row0->nb_category_user == 0){	
	echo"<tr id='uid$id'>
			<th class='uname'>".$row0->tx_name."</th>
			<th class='utel'>$tel</th>
			<th class='umail'>".$row0->tx_email."</th>
			<th class='ucpf'>$cpf</th>
			<th class='text-danger'>Administrador</th>
			<th><button type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='#modalEdUsr' data-catuser='$catuser' data-uid='$id'><i class='nav-icon cui-note'> Editar</button></th>
		</tr>";
	}
	if($row0->nb_category_user == 1){		
	echo"<tr id='uid$id'>
			<th class='uname'>".$row0->tx_name."</th>
			<th class='utel'>$tel</th>
			<th class='umail'>".$row0->tx_email."</th>
			<th class='ucpf'>$cpf</th>
			<th class='text-success'>Gerente</th>
			<th><button type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='#modalEdUsr' data-catuser='$catuser' data-uid='$id'><i class='nav-icon cui-note'> Editar</button></th>
		</tr>";
	}
	if($row0->nb_category_user == 2){		
	echo"<tr id='uid$id'>
			<th class='uname'>".$row0->tx_name."</th>
			<th class='utel'>$tel</th>
			<th class='umail'>".$row0->tx_email."</th>
			<th class='ucpf'>$cpf</th>
			<th>Base</th>
			<th><button type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='#modalEdUsr' data-catuser='$catuser' data-uid='$id'><i class='nav-icon cui-note'></i> Editar</button></th>
		</tr>";
	}
	
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
<div class="modal" style="text-align: left" id="modalUsr" tabindex="-1" role="dialog" aria-labelledby="modalUsr" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalUsr">Novo Usuário</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h4>
								<form>
    <div class="form-row">			
	  <div class="form-group col-12">
		<label for="formUser">Nome: </label>
		<input style="text-transform: uppercase;" type="text" class="form-control" id="formUser" placeholder="" name="Usuario">
	  </div>
	</div>
	<div class="form-row">		
	  <div class="form-group col-8">
		<label for="formCPF">CPF:<span class='text-danger'>*</span></label>
		<input type="text" class="form-control" id="formCPF" name="CPF" placeholder="000.000.000-00" max-length="14" >
	  </div>
	  <div class="form-group col-4">	
			<div class="form-group">
				<label for="formCatuser">Tipo: </label>
				<select class="form-control" id="formCatuser" name="Catuser">
					<option value='0'>Administrador</option>
					<option value='1'>Gerente</option>
					<option selected value='2'>Base</option>
				</select>  
			 </div>
		</div> 
	</div> 
	<div class="form-row">		
	  <div class="form-group col-6">
		<label for="formEmail">E-mail: </label>
		<input type="text" class="form-control" id="formEmail" name="Email">
	  </div>
	  <div class="form-group col-6">
		<label for="formTel">Contato: </label>
		<input type="text" class="form-control" id="formTel" name="Telefone" placeholder="(00) 0.0000-0000" max-length="16" >
	  </div>
	</div> 
	<a class='btn btn-primary float-right' href="javascript:formProc();" role='button'><i class='nav-icon cui-check'></i> Cadastrar</a>
			</h4></form><div id="process"></div>
			  </div>
			    <div class="modal-footer">
				
				</div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='nav-icon cui-ban'></i> Fechar</button>
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
	<a class='btn btn-primary float-right' href="javascript:formProc();" role='button'><i class='nav-icon cui-pencil'></i> Atualizar</a>
			</h4></form><div id="process"></div>
			  </div>
			    <div class="modal-footer">
				
				</div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='nav-icon cui-ban'></i> Fechar</button>
			  </div>
			</div>
		  </div>
		  
