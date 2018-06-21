<?php 	require"conn.php"; ?>
	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">Central</li>
		</ol>
	</nav>
	<div class="container-fluid">
		<div class="card">
			<div class='card-header'>
			<div class="row mt-4">
				<div class="col-7">
				<h3>Sistema FireSystems.online:</h3>
					</div>
					<div class='col-5'>
						<h3 class='btn btn-outline-success float-right'>Administrador - <?php echo "Data Atual: ".date("d/m/Y", $_SERVER['REQUEST_TIME']);?></h3>
					</div>
				</div>
			</div> 	
			
			<div class="card-body">
				<div class='row justify-content-center'>
					<div class='col-6'>
					<a class='btn btn-outline-danger ' href="javascript:loadPhp('pedidos.php');" role='button'><strong>Situação dos Pedidos</strong></a>
					
					<a class='btn btn-outline-danger ' href="javascript:loadPhp('usuarios.php');" role='button'><strong>Usuários</strong></a>
					
					<a class='btn btn-outline-danger ' href="javascript:loadPhp('');" role='button'><strong>Alocar Funcionário</strong></a>
				
					</div>
				</div>	
			</div>
		</div>
    </div>			