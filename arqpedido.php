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
	

	require("./controller/agentController.php");
	Auth::accessControl($_SESSION['catuser'],0);
	
    require("./DB/conn.php");
    require("./controller/pedidosController.php");
    
    $pid = $_REQUEST['Pid'];
    $pedido = getPedidoData($conn,$pid);
    $arquivos = getArquivosPedido($conn,$pid);

?>

	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
		<li class="breadcrumb-item "><a href="central.php">Central</a></li>
			<li class="breadcrumb-item "><a href="javascript:loadPhp('pedidos.php');">Pedidos por Cliente</a></li>
            <li class="breadcrumb-item active"><a href="javascript:atvPhp('<?php echo $pid ?>');">Detalhes do Pedido</a></li>
			<li class="breadcrumb-item active">Arquivos Técnicos do Pedido</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class='card-header'><div class='row mt-1'><div class='col-8'>
						<h3><i class='nav-icon cui-paperclip'></i> Arquivos Anexados ao Pedido: </h3>
                        <h5><cite> <?php echo $pedido->tx_codigo;?></cite> - <?php echo $pedido->tx_nome;?></h5>
                        </div>
						<div class='col-4'>    
						<button type='button' class='btn btn-primary float-right' data-toggle='modal' data-target='#modalDUpload'>
						<i class='nav-icon cui-paperclip'></i> Anexar Arquivo</button>	
						</div>
						</div>
					</div>	
					<div class="card-body">

<!------ LISTAGEM GERAL DOS ARQUIVOS --------------------------------------->
  <div class="row m-auto">
 	<h4 class='col-6'><cite>Arquivos Cadastrados: </h4>
	<table class='table table-striped shadow rounded'>
		<thead>
			<tr>
				<th>Nome do Arquivo</th>
				<th>Descrição</th>
				<th>Tipo do Arquivo</th>
				<th>Tamanho</th>
				<th>Data de Upload</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<?php	

foreach($arquivos AS $arquivo){
	
	if($arquivo->nb_tamanho >= 1024 && $arquivo->nb_tamanho < 1048576){
		$tamanho = 1*$arquivo->nb_tamanho/1024;
		$tamanho = number_format($tamanho,1,'.',',').' kB';
	
	} else if($arquivo->nb_tamanho >= 1048576){
		$tamanho = 1*$arquivo->nb_tamanho/1024/1024;
		$tamanho = number_format($tamanho,1,'.',',').' MB';
	}else $tamanho = $arquivo->nb_tamanho.' bytes';
	// Aloca os medicaos e cria a list
	echo"<tr>
			<td><a class='btn btn-ghost-primary' href='download.php?token=".md5(session_id())."&data=".md5($pid)."&fname=".$arquivo->tx_arquivo."&type=tecnico'><i class='nav-icon cui-cloud-download'></i> ".$arquivo->tx_arquivo."</a></td>
			<td>".$arquivo->tx_documento."</td>
			<td>".$arquivo->tx_version."</td>
			<td>".$tamanho."</td>
			<td>".data_usql($arquivo->dt_upload)."</td>
			<td><button type='button' class='btn btn-danger mx-auto' data-toggle='modal' data-target='#modalExArquivo' value=".$arquivo->tx_arquivo.">
			<i class='nav-icon cui-trash'></i> Excluir</button></td>
		</tr>";	
	
	}	
?>
		</tbody>
	</table>
</div>  
</div 
	<div class="card-footer"><cite></cite></div>
	</div>
</div>
<!-- Page Closing ------------------------->

        </div>
    </div>
<!-- Modal Remover Pedido ------------------------->
<div class="modal" style="text-align: left" id="modalExArquivo" tabindex="-1" role="dialog" aria-labelledby="modalExArquivo" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalExArquivo">Excluir Arquivo</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
	<h4>Deseja excluir este arquivo do sistema?</h4>
	
		<form>
			<input type="text" class="form-control" value="<?php echo $pid;?>" id="Pid" hidden>
			<input type="text" class="form-control" id="exclude-file" disabled>
		</form>

	<div class='row my-3'>
		<div class='col-6'>
	
		</div>
		<div class='col-6'>
	<button type="button" class="btn btn-danger float-left" value="tecnico" id="excluirArquivo"><i class='nav-icon cui-trash'></i> Excluir</button>
	<button type="button" class="btn btn-primary float-right" data-dismiss="modal"><i class='nav-icon cui-ban'></i> Cancelar</button>
		</div>
			</div>
			  </div>
			    <div class="modal-footer">
					<div id="process"></div>
				</div>
				
			  </div>
			</div>
		  </div>

<!-- MODAL UPLOAD DOCS TECNICOS                --------------------------------------------------------------------------------------------------------->
<div class="modal" style="text-align: left" id="modalDUpload" tabindex="-1" role="dialog" aria-labelledby="modalDUpload" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalDUpload">Anexar Arquivo Técnico</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h4>
								<form id="formArquivos" method="POST" enctype="multipart/form-data">
	  <div class="form-row">
		<div class="form-group col-12" >
		<label for="file-upload">Selecionar Arquivo:<input type="file" id="file-upload" name="uploadedFile"></label>
	  </div>
	  <p><small><i class="nav-icon cui-check"></i> Tipos de Arquivos Suportados: Desenho: .DWG ou Documento: .PDF.</small></p>
	  </div>
	<div class="form-row">
		<div class="form-group col-12">
		<label for="formDescricao">Descrição: </label>
			<input type="text" require class="form-control" id="formDescricao">
		</div>
		<input type="text" class="form-control" value="<?php echo $pid;?>" id="Pid" hidden>
	</div>	  
	
	<button class="btn btn-primary float-right px-2" class="form-control" role="button" value='Uptecnico' id="uploadBtn">
		<i class="nav-icon cui-paperclip"></i> Anexar Arquivo</button>
			</h4></form>
			  </div>
			    <div class="modal-footer">
				<p><cite></cite></p>
				</div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="nav-icon cui-action-undo"></i> Fechar</button>
			  </div>
			</div>
		  </div>