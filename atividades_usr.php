
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
	$pid = $_REQUEST["pid"];

//Carrega dados do pedido
$stmt3 = $conn->query("SELECT p.*, c.tx_nome FROM pedido p INNER JOIN cliente c ON p.id_cliente = c.id_cliente WHERE p.id_pedido = $pid");
$row3 = $stmt3->fetch(PDO::FETCH_OBJ);
echo"<div class='card-body border border-primary rounded-top'>
			
			<h2>Atividades na <cite>".$row3->tx_nome."</cite></h2>
			<h3>Área: <label class='border border-secondary rounded p-1'>".$row3->tx_local."</label></h3>
	
		
	 </div>";
				
	echo"<div class='card-body'>
			<h3>Atividades por Categoria:</h3>
			";
			
// Carrega o grupo das atividades result das atividades
$stmt1 = $conn->query("SELECT c.*, (a.nb_valor / a.nb_qtd) v_unit FROM atividade a  
		INNER JOIN categoria c ON a.id_categoria=c.id_categoria
		WHERE a.id_pedido = $pid GROUP BY a.id_categoria ASC");
		
if($stmt1->rowCount() == 0){
		echo"<h4 class='text-danger'>Não há atividades cadastradas para este pedido.</h4>";}
	else{	

//Inicia card para organização das Categorias

while($row1 = $stmt1->fetch(PDO::FETCH_OBJ)){	

	$cid = $row1->id_categoria;
	$cpercent = $count = $execpercent = $medpercent = $balpercent = $balance = 0;	

	$stmt2 = $conn->query("SELECT id_categoria, SUM(nb_valor) nbvalor, SUM(valor_sum) valorsum, SUM(qtd_sum) qtdsum, SUM(nb_qtd) nbqtd, CAST(SUM(progresso) AS DECIMAL(10,2)) progresso, v_unit FROM v_categoria_sums WHERE id_pedido = $pid AND id_categoria = $cid GROUP BY id_categoria");
	$row2 = $stmt2->fetch(PDO::FETCH_OBJ);
	
	
		//Inicia accordion para cada categoria
	echo"
<div class='accordion border border-success rounded-top mb-3' id='accordion'>
  <div class='card mb-0'>
    <div class='card-header' id='headingCat$cid'>
      <h5 class='mb-0'>
	    <div class='row'>
		
		<div class='col-5'>";
		echo"<button class='btn btn-outline-success float-left' type='button' data-toggle='collapse' data-target='#collapseCat$cid' aria-expanded='true' aria-controls='collapseCat$cid'><strong>";
		echo $row1->tx_nome;
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
		
		
        $stmt2 = $conn->query("SELECT a.*, v1.qtd_sum, v1.progresso, v1.nb_valor, v1.valor_sum FROM atividade a 
		LEFT JOIN v_categoria_sums v1 ON a.id_atividade=v1.id_atividade 
		WHERE a.id_pedido = $pid AND a.id_categoria = $cid AND a.cs_finalizada = 0 AND NOT a.dt_inicio = '00-00-0000' ");
		
		
		while($row = $stmt2->fetch(PDO::FETCH_OBJ)){
		if($row->cs_finalizada	== 1) $encerradas += 1;
		echo"	
		<div class='row align-items-center'>
						
						
		<div class='col-12 p-1'>
			<div class='callout callout-success b-t-1 b-r-1 b-b-1 m-1 col-12 p-2 float-left'>
			
			<div class='progress-group-prepend'>";
		  if($row->cs_finalizada == 0) 

					echo "<div class='progress-group-header align-items-end' style='color: #27b;'>
					<button type='button' class='btn btn-outline-dark p-1' data-toggle='modal' data-target='#modalUpdate' data-atividade='" . $row->tx_descricao . "' data-id_atividade='" . $row->id_atividade . "'><strong><i class='nav-icon cui-cursor'></i> " . $row->tx_descricao . "</strong></div>";
		  $percent = ($row->qtd_sum / $row->nb_qtd) * 100;
		  $percent = round($percent,1);
		  echo "<div class='ml-auto'>Progresso: " . $row->qtd_sum . " / " . $row->nb_qtd ." ". $row->tx_tipo . "</div>";
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
			$stmt3 = $conn->prepare("UPDATE atividade SET cs_finalizada = 1 WHERE id_atividade = :aid");
			$stmt3->bindParam(':aid', $row->id_atividade);
			$stmt3->execute();
		}
		}
		$pendentes = $stmt2->rowCount() - $encerradas;
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

<!-- Modal Update Atividade  -->
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
		<label for="formQtdin">Quantidade:</label>
		<input type="text" class="form-control" id="formQtdin" placeholder="Insira Quantidade" name="Qtdin">
		<input type="text" class="form-control" id="formAid" name="Aid" hidden>
	  </div>
	  <div class="form-group col-4">
			<label for="formData">Data:</label>
			<input type="text" class="form-control date" id="formData" value="<?php echo date('d/m/Y');?>" >
		  </div>
	</div>
	  
	<div class="form-row align-items-center">			
	  
	</div>
	<a class='btn btn-primary float-right' href="javascript:formProc();" role='button'><i class='nav-icon cui-check'></i> OK</a>
			</h4></form><div id="process"></div>
							  </div>
							  <div class="modal-footer">
								<h6 id="success"><small></small></h6>
								<div class="alert alert-secondary mr-auto" role="alert">
								<h6><?php echo"Obra: ".$row3->tx_nome.", ".$row3->tx_local.".";?> </h6>
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