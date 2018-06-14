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
						<?php echo date("d/m/Y", $_SERVER['REQUEST_TIME']);?>
						</h2>
					
				
						
					


<?php $cid = $row1->id_categoria;
	$cpercent = $count =0;	
	$stmt2 = $conn->query("SELECT id_categoria, SUM(nb_valor) nbvalor, SUM(valor_sum) valorsum, SUM(qtd_sum) qtdsum, SUM(nb_qtd) nbqtd, CAST(SUM(progresso) AS DECIMAL(10,2)) progresso, v_unit FROM v_categoria_sums WHERE id_pedido = $pid AND id_categoria = $cid GROUP BY id_categoria");
	$row2 = $stmt2->fetch(PDO::FETCH_OBJ)
		
	$execpercent = ($row2->progresso / $row2->nbvalor) * 100;
	$execpercent = round($execpercent,1);
	
	$medpercent = ($row2->valorsum / $row2->nbvalor) * 100;
	$medpercent = round($medpercent,1);	
		?> 
<div class='accordion  border border-success rounded-top" id="accordion'>
  <div class='card mb-0'>
    <div class='card-header' id='headingCat$cid'>
      <h5 class='mb-0'>
	    <div class='row'>
		
		<div class='col-3'>
		echo"<button class='btn btn-outline-success float-left' type='button' data-toggle='collapse' data-target='#collapseCat$cid' aria-expanded='true' aria-controls='collapseCat$cid'><strong>";
		echo $row1->tx_nome;
		echo"</strong></button>";
		</div>
		 
		<div class='col-4'>
				<div class='callout callout-info'>
				  <small class='text-muted'>Progresso Categoria</small><br>
				  <strong class='h6'>".$execpercent."% - (R$ ".$row2->progresso."/".$row2->nbvalor.")</strong>
			</div>
		</div>
		</div>
      </h5>
    
	</div>

    <div id='collapseCat$cid' class='collapse' aria-labelledby='headingCat$cid' data-parent='#accordion'>
      <div class="card-body"><!-- MAIN WHILE FOR ATIVIDADE CATEGORIA -->
	  
        $stmt2 = $conn->query("SELECT a.*, v1.qtd_sum FROM atividade a 
		LEFT JOIN v_sum_atividade_exec v1 ON a.id_atividade=v1.id_atividade 
		WHERE a.id_pedido = $pid AND a.id_categoria = $cid");
		
		while($row = $stmt2->fetch(PDO::FETCH_OBJ)){
			
		<div class="row align-items-center">
						
						
				<div class="col-sm-10 p-1">
    <div class="callout callout-danger b-t-1 b-r-1 b-b-1 m-1 col-12 float-left">
			
	  <div class="progress-group-prepend">
		  if($row->cs_finalizada == 0) 
					echo "<div class='progress-group-header align-items-end' style='color: #27b;'><strong>" . $row->tx_descricao . " (Ativa)</strong></div>";
		  if($row->cs_finalizada == 1) 
					echo "<div class='progress-group-header align-items-end' style='color: #777;'><strong>" . $row->tx_descricao . " (Encerrada)</strong></div>";
		  $percent = ($row->qtd_sum / $row->nb_qtd) * 100;
		  echo "<div class='ml-auto'>Progresso: (" . round($percent) ."%) - ";
		  echo $row->qtd_sum . " / " . $row->nb_qtd . $row->tx_tipo . "</div>";
			  
		  <div class="progress-group-bars mb-1">
			<div class="progress progress">
			  <div class="progress-bar bg-orange" role="progressbar" style='width: ".round($percent)."%' aria-valuenow='".round($percent)."' aria-valuemin='0' aria-valuemax='100'></div>
			</div>
		  </div>
		  <div class="progress-group-bars mb-1">
			<div class="progress progress">
			  <div class="progress-bar bg-info" role="progressbar" style='width: ".round($percent)."%' aria-valuenow='".round($percent)."' aria-valuemin='0' aria-valuemax='100'></div>
			</div>
		  </div>
		</div>
		</div><!--/.callout-->
				</div><!--/.col-->
							
				<div class="col-sm-2 p-1 ">	
			
			<div class="custom-control custom-checkbox form-control-sm">
				<input type="checkbox" class="custom-control-input" id="validMedicao">
				<label class="custom-control-label" for="validMedicao">Medir</label>
				<div class="text-muted float-right">916.000,00</div>
			 </div>
				
				  <div class="input-group input-group-sm">
					<div class="input-group-prepend">
					  <span class="input-group-text" id="inputGroupPrepend">%</span>
					</div>
					<input type="text" class="form-control form-control-sm" id="validationCustomUsername" placeholder="0" aria-describedby="inputGroupPrepend"> 
					</div>
				</div><!--/.col-->
					
		</div><!--/.BAR CALLOUT INFO GROUP END ROW -->
	
		
		
		}
		
      </div>
    </div>
	<div class="card-footer text-muted">
		2 days ago
	</div>
  </div>
</div>


	




		</div>	<!--/.general body card-->		
	</div>	<!--/.general card-->
</div>	<!--/.container-fluid-->
<?php
	
	
	
?>