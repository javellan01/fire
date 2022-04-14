<style>
      .btn {
        white-space: normal;
      }
</style>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item ">
			<li class="breadcrumb-item "><a href="central_usr.php">Central</a></li>
			</li>	
			<li class="breadcrumb-item "><a href="javascript:loadPhp('pedidos_usr.php');">Pedidos</a></li>
			<li class="breadcrumb-item active">Atividades</li>
		</ol>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 ">
				<div class="card">
					
<?php
	session_start(); 
	require("./controller/agentController.php");
	Auth::accessControl($_SESSION['catuser'],2);	
	require("./DB/conn.php");
	require("./controller/atividadesUsrController.php");
	$pid = $_REQUEST["pid"];
	$pedido = getUsrPedidoData($conn,$pid);
//Carrega dados do <pedido>
echo"<div class='card-body border border-primary rounded-top'>
			
			<h2><i class='nav-icon cui-briefcase'></i> Atividades na <cite>".$pedido->tx_nome."</cite></h2>
			<h3><i class='nav-icon cui-location-pin'></i> Área: <label class='border border-secondary rounded p-1'>".$pedido->tx_local."</label></h3>
	
		
	 </div>";
				
	echo"<div class='card-body'>
			<h3>Atividades por Categoria:</h3>
			";
			
// Carrega as categorias das atividades result das atividades
$categorias = getUsrCategoriaPedido($conn,$pid);
		
if(!$categorias){
		echo"<h4 class='text-danger'>Não há atividades cadastradas para este pedido.</h4>";}
	else{	
//Inicia card para organização das Categorias
foreach($categorias AS $categoria){	
	$cid = $categoria->id_categoria;
	//Inicia accordion para cada categoria
	echo"
<div class='accordion border border-success rounded-top mb-3 shadow rounded' id='accordion'>
  <div class='card mb-0'>
    <div class='card-header' id='headingCat$cid'>
      <h5 class='mb-0'>
	    <div class='row'>
		
		<div class='col-5'>";
		echo"<button class='btn btn-outline-success float-left' type='button' data-toggle='collapse' data-target='#collapseCat$cid' aria-expanded='true' aria-controls='collapseCat$cid'><strong>";
		echo $categoria->tx_nome;
		echo" <i class='nav-icon cui-chevron-bottom'></i></strong></button>
		</div>
		</div>
		</div>
      </h5>
	</div>

    <div id='collapseCat$cid' class='collapse show' aria-labelledby='headingCat$cid' data-parent='#accordion'>
      <div class='card-body'>";
	  
	//  <!-- MAIN WHILE FOR ATIVIDADES DA CATEGORIA -->
	$encerradas = 0;
	$atividades = getUsrAtividades($conn,$pid,$cid);

	foreach($atividades AS $atividade){	

		if($atividade->cs_finalizada == 1) $encerradas += 1;
		echo"	
		<div class='row align-items-center'>
		
		<div class='col-12 p-1'>
			<div class='callout callout-success b-t-1 b-r-1 b-b-1 m-1 col-12 p-2 float-left'>
			
			<div class='progress-group-prepend'>";
		  if($atividade->cs_finalizada == 0) 
			echo "<div class='progress-group-header align-items-end' style='color: #27b;'>
			<button type='button' class='btn btn-outline-dark px-2 py-1 m-1' 
			data-toggle='modal' data-target='#modalAtividadeCalendario' value='".$atividade->id_atividade."' data-descricao='" . $atividade->id_idx . " - " . $atividade->tx_descricao . "'><i class='nav-icon cui-calendar'></i></button>
			<button type='button' class='btn btn-outline-dark py-1 m-1' data-toggle='modal' data-target='#modalUpdate' data-atividade='" . $atividade->tx_descricao . "' data-id_atividade='" . $atividade->id_atividade . "'><strong>" . $atividade->id_idx . " - " . $atividade->tx_descricao . "</strong></div>";
		  $percent = ($atividade->qtd_sum / $atividade->nb_qtd) * 100;
		  $percent = round($percent,1);
		  echo "<div class='ml-auto'>Progresso: " . $atividade->qtd_sum . " / " . $atividade->nb_qtd ." ". $atividade->tx_tipo . "</div>";
		  echo"	  
		  <div class='progress-group-bars mb-1'>
			<div class='progress progress-lg'>
			  <div class='progress-bar bg-orange' role='progressbar' style='width: ".$percent."%' aria-valuenow='".$percent."' aria-valuemin='0' aria-valuemax='100'>".$percent."%</div>
			</div>
		  </div>
		</div>
		</div><!--/.callout-->
				</div><!--/.col-->
		</div><!--/.BAR CALLOUT INFO GROUP END ROW -->";
		if($percent >= 100){
			setUsrAtividadeFinalizada($conn,$atividade->id_atividade);	
		}

		}
		$pendentes = count($atividades) - $encerradas;
	echo"	
      </div>
    </div>
	<div class='card-footer'>
		<div class='row'>
			<div class='col-6 text-left'>
			</div>
			<div class='col-6 text-right'>
				<h5><label class='border border-danger rounded p-1'>Atividades Pendentes: ".$pendentes."</label></h5>
			</div>
		</div>	
		
	</div>
	</div>";
	}
}



?>
</div></div>

<!-- Modal Registra Atividade  -->
<div class="modal" style="text-align: left" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalUpdate" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="modalUpdate"></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h4>
								<form>
    <div class="form-row">			
	  <div class="form-group col-8">
		<label for="formUqtd"><i class='nav-icon cui-note'></i> Quantidade:</label>
		<input type="text" class="form-control" id="formUqtd" placeholder="Insira Quantidade">
		<input type="text" class="form-control" id="formAid" hidden>
	  </div>
	  <div class="form-group col-4">
			<label for="formData"><i class='nav-icon cui-calendar'></i> Data:</label>
			<input type="text" class="form-control date" id="formUdata" value="<?php echo date('d/m/Y');?>">
		  </div>
	</div>
	  
	<button type='button' class='btn btn-primary float-right' id='registraAtividade' value='1' ><i class='nav-icon cui-check'></i> OK</button>
			</h4></form>
							  </div>
							  <div class="modal-footer">
								<div class="alert alert-secondary mx-auto" role="alert">
								<h6><?php echo"Obra: ".$pedido->tx_nome.", ".$pedido->tx_local.".";?> </h6>
								</div>
								
							  </div>
							  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='nav-icon cui-ban'></i> Fechar</button>
							</div>
						  </div>
						</div>
						
					</div>
				</div>
			</div>	
		</div>
		
	</div>	

<!-- Modal CALENDARIO ------------------------->
<div class="modal" id="modalAtividadeCalendario" tabindex="-1" role="dialog" aria-labelledby="modalAtividadeCalendario" aria-hidden="true">
						  <div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title"><cite>Eventos da Atividade:</cite></h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
	<h5 id='descricao'></h5><br>
	
		<div class='m-1 p-2 shadow rounded' id="calendario">
		</div>
		</div>

			    <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='nav-icon cui-action-undo'></i> Voltar</button>
				</div>
			  </div>
			</div>
		  </div>		  