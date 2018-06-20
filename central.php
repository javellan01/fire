<?php 	require"conn.php"; ?>
	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">Central</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class="card-body">
						<h2 style='text-align: center;'><a class='btn btn-outline-danger' href="javascript:loadPhp('pedidos.php');" role='button'><strong>Situação dos Pedidos</strong></a>
						<a class='btn btn-outline-danger' href="javascript:loadPhp('pedidos_usr.php');" role='button'><strong>Modo Usuário</strong></a>
						<?php echo "Data Atual: ".date("d/m/Y", $_SERVER['REQUEST_TIME']);?>
						</h2>
				</div>
			</div>
    </div>			