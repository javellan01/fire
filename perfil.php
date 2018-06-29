	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item ">
				<?php 
				session_start();
				if($_SESSION['catuser'] == 0) echo"<a href='central.php'>Central</a>";
				if($_SESSION['catuser'] == 1) echo"<a href='central_ger.php'>Central</a>";
				if($_SESSION['catuser'] == 2) echo"<a href='central_usr.php'>Central</a>";
				?>
			</li>	
			<li class="breadcrumb-item active">Perfil</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class='card-header'>
					<div class='row mt-4'>
						<div class='col-8'>
							<h3>Perfil: </h3>
						</div>
						<div class='col-4'>
										
							
						</div>
						</div>
						
					</div>	
					<div class="card-body">
<?php 
	require("./DB/conn.php");
	$uid = $_SESSION['userid'];
	if($_SESSION['catuser'] == 0) $ucat = 'Administrador';
	if($_SESSION['catuser'] == 1) $ucat = 'Gerente';
	if($_SESSION['catuser'] == 2) $ucat = 'Usuário';
	
	$stmt0 = $conn->query("SELECT * FROM usuario WHERE id_usuario = $uid");

	while($row0 = $stmt0->fetch(PDO::FETCH_OBJ)){
	$cpf  = $row0->tx_cpf;
	$tel  = $row0->tx_telefone;
	$nome = $row0->tx_name;
	$email= $row0->tx_email;
	}
	
	?>					
	<div class='row'>
		<!-- info do usuario e alterar senha --->
		<div class='col-5'>
			<div class='card-header'>
				<h5> <?php echo $nome; ?><button type='button' class='btn btn-outline-primary float-right' data-toggle='modal' data-target='#modalEdusr'><i class="cui-pencil"></i></button>
				</h5>
			</div>
			<div class='card-body'>
				<table class='table table-responsive-lg'>
				<tbody>
					<tr><th>Acesso: <?php echo $ucat; ?></th></tr>
					<tr><th>CPF: <?php echo $cpf; ?></th></tr>
					<tr><th>Email: <?php echo $email; ?></th></tr>
					<tr><th>Telefone: <?php echo $tel; ?></th></tr>
				</tbody>	
				</table>
			</div>	
		</div>
		<div class='col-7'>
		<div class='card-header'>
			<h5>Relação de Pedidos Ativos: </h5>
		</div>	
		<div class='card-body'>	
		<table class='table table-responsive-lg table-striped'>
			<thead>
				<tr>
					<th>Cliente</th>
					<th>Pedido</th>
					<th>Local</th>
				</tr>
			</thead>
			<tbody>			
				
<?php
			$stmt0 = $conn->query("SELECT * , c.tx_nome AS cliente FROM pedido p INNER JOIN cliente c ON p.id_cliente = c.id_cliente WHERE id_usu_resp = $uid AND cs_estado = 0 ORDER BY cliente ASC");
			
				while($row0 = $stmt0->fetch(PDO::FETCH_OBJ)){
					echo"<tr>
							<th>".$row0->cliente."</th>
							<th>".$row0->tx_codigo."</th>
							<th>".$row0->tx_local."</th>
						</tr>";
			}
			
?>	
		
		</tbody>	
		</table>
		</div>
		</div>
	</div>
		<div class='row'>
			<div class='col-5'>
			<div class='card-header'>
				<h5>Alterar Senha: </h5>
				</div>
				<div class='card-body'>	
					<div class='col-8'>	
						<form>
						<input class="form-control" type="password" id="formASenha" name="ASenha" placeholder="Nova Senha">
						</form>
					</div>	
					<div class='col-4'>	
						<a class='btn btn-outline-primary float-right' href="javascript:formProc();" role='button'>OK</a>
					</div>	
				</div>
			</div>
		</div>
		<div id='process'><p></p></div>
	</div>
	</div>
</div>		



	
<?php		
$stmt = null;
$stmt0 = null;
?>



<!-- Modal Editar Perfil  -->
<div class="modal" style="text-align: left" id="modalEdusr" tabindex="-1" role="dialog" aria-labelledby="modalEdusr" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalEdusr">Editar Perfil</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h4>
								<form>
    <div class="form-row">			
	  <div class="form-group col-12">
		<label for="formUser">Nome: </label>
		<input style="text-transform: uppercase;" type="text" class="form-control" id="formUser" value="<?php echo $nome; ?>" name="EdUsuario">
	  </div>
	</div>
	<div class="form-row">		
	  <div class="form-group col-8">
		<label for="formCPF">CPF:<span class='text-danger'>*</span></label>
		<input type="text" class="form-control" id="formCPF" name="CPF" value="<?php echo $cpf; ?>" disabled>
	  </div>  
	</div> 
	<div class="form-row">		
	  <div class="form-group col-6">
		<label for="formEmail">E-mail: </label>
		<input type="text" class="form-control" id="formEmail" name="Email" value="<?php echo $email; ?>">
	  </div>
	  <div class="form-group col-6">
		<label for="formTel">Contato: </label>
		<input type="text" class="form-control" id="formTel" name="Telefone" value="<?php echo $tel; ?>" >
	  </div>
	</div>
	<a class='btn btn-primary float-right' href="javascript:formProc();" role='button'>OK</a>
			</h4></form><div id="process"></div>
			  </div>
			    <div class="modal-footer">
				
				</div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			  </div>
			</div>
		  </div>
