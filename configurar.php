<?php 

	session_start(); 
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

	require("./controller/agentController.php");
	Auth::accessControl($_SESSION['catuser'],0);
	require("./controller/configController.php");
	require("./DB/conn.php");

?>

<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="central.php">Central</a></li>
			<li class="breadcrumb-item active">Configuração do Sistema</li>
		</ol>
	</nav>

	<div class="container-fluid">
				<div class="card">
					<div class='card-header'><div class='row mt-1'><div class='col-10'>
						<h3><i class="nav-icon cui-settings"></i> Editar Categorias: </h3></div>
						<div class='col-2'>
						<button type='button' class='btn btn-outline-primary float-right m-1' data-toggle='modal' data-target='#modalNewCat'>+ Nova Categoria</button>
						</div>
						</div>
					</div>	
					<div class="card-body">
	
	<h4><cite> Categorias Cadastradas: </h4>
	<table class='table table-responsive-xl table-striped'>
		<thead>
			<tr>
				<th>Indice</th>
				<th>Nome</th>
				<th>Atividades Cadastradas</th>
				<th>Cor</th>
				<th></th>
        		<th></th>
			</tr>
		</thead>
		<tbody>
<?php	

//Carrrga as users pra colocar na lista
$categorias = getCategorias($conn);

$counter = checkCategorias($conn);

foreach($categorias as $categoria){

	$id = $categoria->id_categoria;	
	
	// Aloca os users e cria a list e todos o modais
	echo"<tr>
			
			<th>".$categoria->id_categoria."</th>
			<th><input type='text' require class='form-control' id='nome$id' value='".$categoria->tx_nome."'></th>
			<th>".$counter[$categoria->id_categoria]."</th>
			<th><input class='btn btn-primary color-picker' id='color$id' value='".$categoria->tx_color."'></input></th>
     		<th><button type='button' class='btn btn-outline-primary updateCategoria'  value='1'
			 data-tx_nome='".$categoria->tx_nome."'
			 data-id_categoria='".$categoria->id_categoria."'><i class='nav-icon cui-pencil'></i> Atualizar</button></th>";
	if($counter[$categoria->id_categoria] != 0){
		echo "<th><button type='button' class='btn btn-outline-dark disabled'><i class='nav-icon cui-trash'></i> Excluir</button></th>";
	}
	else {
		echo "<th><button type='button' class='btn btn-outline-danger removeCategoria' value='1' data-id_categoria='$id'><i class='nav-icon cui-trash'></i> Excluir</button></th>";
	}
      
      
	echo"</tr>";	
	
	}	
	$newid = $id + 1;
?>
		</tbody>
	</table>
	</div>
	<div class="card-footer"><cite>Obs.: As alterações feitas nas categorias afetam todos os pedidos de forma global. Inclusive os inativos e os medidos.</cite></div>
	</div>
</div>

<!-- Modal Nova Categoria  -->
<div class="modal" style="text-align: left" id="modalNewCat" tabindex="-1" role="dialog" aria-labelledby="modalNewCat" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalNewCat">Nova Categoria</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h4>
								<form id="formNewCat">
 	<div class="form-row">			
	  <div class="form-group col-2">
		<label for="formFNome">Indice: </label>
		<input style="text" type="text" required disabled class="form-control" value="<?php echo $newid; ?>">
		<input type="text" class="form-control" value="<?php echo $newid; ?>" id="formCatId" hidden>
	  </div>	
	</div>
	<div class="form-row">		
		<div class="form-group col-12">
			<label for="formCatName">Nome: </label>
			<input type="text" class="form-control" id="formCatName" required placeholder="Nova Categoria" max-length="48" >
		</div>
	</div> 
	<div class="form-row">		
		<div class="form-group col-12">
			<label for="formCatColor">Cor: </label>
			<input class='btn btn-primary color-picker' id="formCatColor" required value="#205090">
		</div>
	</div> 

	<button type='button' class='btn btn-primary float-right' id='novaCategoria' value='1'><i class='nav-icon cui-check'></i> Cadastrar</button>
			</h4></form><div id="process"></div>
			  </div>
			    <div class="modal-footer">
				
				</div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='nav-icon cui-ban'></i> Fechar</button>
			  </div>
			</div>
		  </div>
