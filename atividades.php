
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="central.php">Central</a></li>
			<li class="breadcrumb-item "><a href="javascript:loadPhp('pedidos.php');">Pedidos por Cliente</a></li>
			<li class="breadcrumb-item active">Detalhes do Pedido</li>
		</ol>
	</nav>
	<div class="container-fluid">
		<div class="card">
		<div class='card-header'><div class="row mt-1"><div class="col-9">
			<h3>Detalhes do Pedido: 
					
					
<?php
session_start(); 

require("./controller/agentController.php");
Auth::accessControl($_SESSION['catuser'],0);
require("./DB/conn.php");
require("./controller/atividadesController.php");

$_SESSION['MAtiv'] = array();

$pid = $_REQUEST["pid"];
$balance = array();
$measure = 0.00;
$mid = 0;	
$pedido = getPedidoData($conn, $pid);

//Carrega dados do pedido

echo $pedido->tx_codigo." - <cite>".$pedido->tx_nome."</cite></h3>
							</div>
							<div class='col-3'>
								
							</div>
						</div>
					</div> 	
		<div class='card-body border border-primary rounded-top'>
			<div class='row justify-content-between'>
						<div class='col-8'>
				<h4>Total do Pedido:<label class='border border-secondary rounded p-1'> R$ ".moeda($pedido->nb_valor)."</label> - Retenção: <label class='border border-secondary rounded p-1'>R$ ".moeda($pedido->retencao)." (".$pedido->nb_retencao."%)</label>
						</div>
						<div class='col-4'>
						<h4>Data Ínicio: <label class='border border-secondary rounded p-1'>".data_usql($pedido->dt_idata)."</label>
							</h4>
						</div>
						</div>
		<div class='row'>
			<div class='col-8'>
			<h4>Área: <label class='border border-secondary rounded p-1'>".$pedido->tx_local."</label></h4>
			</div>
			<div class='col-4'>
				<h4>Data Término: <label class='border border-secondary rounded p-1'>".data_usql($pedido->dt_tdata)."</label>
					</h4>
		</div>
		</div>	
		<div class='row'>
			<div class='col-12 border border-secondary'>
			<h4>Informações Relacionadas: </h4>
			
				<p class='m-2'>".$pedido->tx_descricao."</p><br><br>
			</div>	
		</div>			
		</div>
		
	<div class='card-body'>";

// Carrega as somas result das medições
$medicoes = getMedicoes($conn, $pid);

echo"<div class='accordion border border-danger rounded-top mb-3' id='accordion'>
		<div class='card mb-0'>
			<div class='card-header' id='headingMedicao'>
				<h5 class='mb-0'>
				<button type='button' class='btn btn-outline-danger float-left'  data-toggle='collapse' data-target='#collapseMedicao' aria-expanded='true' aria-controls='collapseMedicao'>Medições Cadastradas 
				</button>
				<button type='button' class='btn btn-outline-primary float-right' data-toggle='modal' data-target='#modalVMedir'>+ Nova Medição
				</button>
				</h5>
			</div>
				
			<div id='collapseMedicao' class='collapse' aria-labelledby='headingMedicao' data-parent='#accordion'>
				<div class='card-body'>";
	
if(count($medicoes) == 0){
		echo"<div class='card border border-light'><h4>Não há medições cadastradas para este pedido. </h4></div>";}
	else{					
foreach($medicoes as $medicao){

	$mid=$medicao->nb_ordem;	
	echo"		  
		<div class='card border border-light mb-3'>
		  <h5 class='card-header'>Medição ".$mid." - ".data_usql($medicao->dt_data)."<button type='button' class='btn btn-primary float-right' data-toggle='modal' data-target='#modalSend$mid'><i class='nav-icon cui-envelope-closed'></i> Enviar Notificação de Medição</button></h5>
		  
		  <div class='card-body'>
			<h5 class='card-title'>Valor Medido: R$ ".moeda($medicao->v_medido)." - ".calcularPercent($medicao->v_medido,$pedido->nb_valor,1)."% do Pedido, Status: ".getAprovacao($conn,$medicao->id_medicao)."</h5>
			<h4 class='cart-text'>Responsável: ".$medicao->tx_name."</h4>
			<p class='card-text'>Nota: ".$medicao->tx_nota." - Vencimento: ".$medicao->dt_vencimento."</p>
			<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modalLAtv$mid'><i class='nav-icon cui-list'></i> Listar Atividades Medidas</button>
			
			</div>
		</div>
		<div class='modal' style='text-align: left' id='modalLAtv$mid' tabindex='-1' role='dialog' aria-labelledby='modalLAtv$mid' aria-hidden='true'>
			  <div class='modal-dialog modal-lg' role='document'>
				<div class='modal-content'>
				  <div class='modal-header border border-danger rounded-top'>
					<h5 class='modal-title' id='modalLAtv$mid'><cite>".$pedido->tx_codigo."</cite> - Medição ".$mid."</h5>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					  <span aria-hidden='true'>&times;</span>
					</button>
				  </div>
				  <div class='modal-body'><h6>
				  <table class='table table-striped'>
					<thead>
						<tr>
							<th>Item</th>
							<th>Atividade</th>
							<th>Categoria</th>
							<th>Percentagem</th>
							<th>Valor</th>
						</tr>
					</thead>
					<tbody>";
				$medidas = getMedicaoResume($conn,$pid,$mid);
				$item = 1;
				foreach($medidas as $medida){
					echo"<tr>
							<th>".$item.".</th>
							<th>".$medida->tx_descricao."</th>
							<th>".$medida->tx_nome."</th>
							<th>".moeda($medida->percent)."%</th>
							<th>R$ ".moeda($medida->nb_valor)."</th>
						</tr>";
					$item += 1;	
					}
			echo"
					<tr>
						<th></th><th></th><th></th><th></th><th></th>
					</tr>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th>Total:</th>
						<th style='font-weight: 500;'>R$ ".moeda($medicao->v_medido)."
					</tr>		
					</tbody>
					</table>		
					</h6>	
					</div>
					<div class='modal-footer'>
				  </div>
				  <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
				</div>
			  </div>
			</div>";
		
		
		}
	}
	$mid += 1;
echo"</div></div></div></div>";
		echo"

			<button type='button' class='btn btn-outline-primary float-right' data-toggle='modal' data-target='#modalCenter'>+ Nova Atividade</button>
			<h3 class='mb-3'>Atividades por Categoria:</h3>
			";
			
// Carrega as categorias
$categorias = getCategoria($conn,$pid);
		
if(count($categorias) == 0){
		echo"<h4 class='danger'>Ainda não há atividades cadastradas para este pedido!</h4>";}
	else{	

//Inicia card para organização das Categorias

foreach($categorias as $categoria){	

	$cid = $categoria->id_categoria;
	$cat = getCategoriaSum($conn,$pid,$cid);
	$atividades = getAtividades($conn,$pid,$cid);

	$cpercent = $count = $execpercent = $medpercent = $balpercent = 0;
	
		//Inicia accordion para cada categoria
	echo"
<div class='accordion border border-success rounded-top mb-3' id='accordion'>
  <div class='card mb-0'>
    <div class='card-header' id='headingCat$cid'>
      <h5 class='mb-0'>
	    <div class='row'>
		
		<div class='col-5'>";
		echo"<button class='btn btn-outline-success float-left' type='button' data-toggle='collapse' data-target='#collapseCat$cid' aria-expanded='true' aria-controls='collapseCat$cid'><strong>";
		echo $categoria->tx_nome;
		echo"</strong></button>
		</div>
		 
		<div class='col-7'>";
				
				if( $cat->progresso > $cat->nbvalor){
					
				echo"  <div class='callout callout-danger m-0'>
							<small class='text-muted text-danger'>Progresso Categoria</small><br>
							<strong class='h5 text-danger text-nowrap'>".$cat->execpercent."% - (R$ ".moeda($cat->progresso)."/".moeda($cat->nbvalor).")</strong>";
				}
				else{
				echo"  <div class='callout callout-success m-0'>
							<small class='text-muted text-success'>Progresso Categoria</small><br>
							<strong class='h5 text-success text-nowrap'>".$cat->execpercent."% - (R$ ".moeda($cat->progresso)."/".moeda($cat->nbvalor).")</strong>";
				}
		echo"		
			</div>
		</div>
		</div>
      </h5>
    
	</div>

    <div id='collapseCat$cid' class='collapse show' aria-labelledby='headingCat$cid' data-parent='#accordion'>
      <div class='card-body'>
	  
	  <!-- MAIN WHILE FOR ATIVIDADE CATEGORIA -->";
		$encerradas = 0;
		$subtotal = 0.00;
foreach($atividades AS $atividade)  {
		if($atividade->cs_finalizada	== 1) $encerradas += 1;	
		if($atividade->valor_sum == null) $atividade->valor_sum = 0;

		if(is_null($atividade->medpercent)){
			$atividade->medpercent = '0.0';
		}
		if(is_null($atividade->execpercent)){
			$atividade->execpercent = '0.0';
		}

		$balpercent = $atividade->execpercent - $atividade->medpercent;
		
		if($balpercent < 0) $balpercent = 0;
		if($balpercent > 100) $balpercent = 100;
		$balance[$atividade->id_atividade] = round(($atividade->progresso - $atividade->valor_sum),2);
		if($balance[$atividade->id_atividade] < 0) $balance[$atividade->id_atividade] = 0;	
		if($balance[$atividade->id_atividade] > $atividade->nb_valor) $balance[$atividade->id_atividade] = $atividade->nb_valor;
		echo"	
		<div class='row align-items-center'>
						
						
		<div class='col-12 p-1'>
			<div class='callout callout-success b-t-1 b-r-1 b-b-1 m-1 col-12 float-left'>
			
			<div class='progress-group-prepend'>";
		  if($atividade->cs_finalizada == 0) 
					echo "<div class='progress-group-header align-items-end'><button type='button' class='btn btn-outline-primary p-1' data-toggle='modal' data-target='#modalUpdate' data-atividade='" . $atividade->tx_descricao . "' data-id_atividade='" . $atividade->id_atividade . "'><strong>" . $atividade->tx_descricao . "</strong></div>";
		  if($atividade->cs_finalizada == 1) 
					echo "<div class='progress-group-header align-items-end' style='color: #777;'><strong>" . $atividade->tx_descricao . " (Encerrada)</strong></div>";
		  $percent = ($atividade->qtd_sum / $atividade->nb_qtd) * 100;
		  $percent = round($percent,1);
		  echo "<div class='ml-auto'>Progresso: " . $atividade->qtd_sum . " / " . $atividade->nb_qtd ." ". $atividade->tx_tipo . "</div>";
		  echo"	  
		  <div class='progress-group-bars mb-1'>
			<div class='progress progress'>
			  <div class='progress-bar bg-orange' role='progressbar' style='width: ".$atividade->percent."%' aria-valuenow='".$atividade->percent."' aria-valuemin='0' aria-valuemax='100'>".$atividade->percent."% Executados</div>
			</div>
		  </div>
		  <div class='progress-group-bars mb-1'>
			<div class='progress progress'>
			  <div class='progress-bar bg-primary' role='progressbar' style='width: ".$atividade->medpercent."%' aria-valuenow='".$atividade->medpercent."' aria-valuemin='0' aria-valuemax='100'>".$atividade->medpercent."% Medidos</div>
			</div>
		  </div>
		</div>
		</div><!--/.callout-->
				</div><!--/.col--></div>";
		$subtotal +=  $balance[$atividade->id_atividade];
		$pendentes = count($atividades) - $encerradas;
		echo"<div class='row'><h6></h6></div>";
		}
		$measure += $subtotal;
	echo"	
      </div>
    </div>
	<div class='card-footer'>
		<div class='row'>
			<div class='col-6 text-muted text-left'>
				<h5 class='mb-0'><label class='border border-danger rounded p-1'>Ativas: ".$pendentes."</label> / <label class='border border-success rounded p-1'>Encerradas: ".$encerradas.".</label></h5>
			</div>
			<div class='col-6 text-right'>
				<h5 class='mb-0'><label class='border border-primary rounded p-1'>Total Atividades: ".count($atividades)."</label>    -  Saldo: R$ ".moeda($subtotal)."</h5>
			</div>
		</div>	
		
	</div>
	</div>
	</div>";
	}
}



?>
</div></div>

<!-- Modal Nova Atividade  -->
<div class="modal" style="text-align: left" id="modalCenter" tabindex="-1" role="dialog" aria-labelledby="modalCenter" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="modalCenter">Criar Atividade</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h4>
								<form>
    <div class="form-row">			
	  <div class="form-group col-md-8">
		<label for="formAtividade">Atividade:</label>
		<input type="text" class="form-control" id="formAtividade" placeholder="Descrição Atividade" name="Atividade">
	  </div>
	  <div class="form-group col-md-4">
		<label for="formTubo">Ø:<small class='text-muted'><cite>(Diâmetro)</cite></small></label>
		<select class="form-control" id="formTubo" name="Tubo">
		  <option></option>
		  <option>Ø3/4"</option>
		  <option>Ø1"</option>
		  <option>Ø1.1/4"</option>
		  <option>Ø1.1/2"</option>
		  <option>Ø2"</option>
		  <option>Ø2.1/2"</option>
		  <option>Ø3"</option>
		  <option>Ø4"</option>
		  <option>Ø6"</option>
		  <option>Ø8"</option>
		  <option>Ø10"</option>
		  <option>Ø12"</option>
		  <option>Ø14"</option>
		</select>
	  </div>
	</div> 
	
	<div class="form-row">			
	  <div class="form-group col-md-5">
		<label for="formQtdin">Quantidade:</label>
		<input type="text" class="form-control" id="formQtdin" placeholder="Número Inteiro" name="Qtd">
		<input type="text" class="form-control d-none" id="formID" name="Pid" value="<?php echo$pid?>" readonly>
	  </div>
	  <div class="form-group col-md-3">
		<label for="formTipo">Tipo:</label>
		<input style="text-transform: uppercase;" type="text" class="form-control" id="formTipo" placeholder="PÇ, VB, CJ, ..." name="Tipo"> 
	  </div>
	  <div class="form-group col-md-4">
		<label for="formValor">Valor:</label>
		<input type="text" class="form-control" id="formValor" placeholder="0.00" name="Valor">
	  </div>
	  
	</div>
	<div class="form-row">			
	  <div class="form-group col-8">
		<div class="form-group">
		<label for="formCategoria">Categoria:</label>
			<select class="form-control" id="formCategoria" name="Categoria">
			<option selected hidden>Selecionar Categoria</option>
<?php 	$stmt = $conn->query("SELECT * FROM categoria ORDER BY id_categoria ASC");
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){ 
			  echo "<option value=".$row->id_categoria.">".$row->tx_nome."</option>";
			}
			  ?>
			</select>
		  </div>
		 </div>
		 <div class="form-row">	
		  <div class="form-group col-6">
			<label for="formiData">Data Início:</label>
			<input type="text" class="form-control date" id="formiData" value="<?php echo date('d/m/Y');?>" name="iData">
	  </div>
		<div class="form-group col-6">
			<label for="formfData">Data Fim:</label>
			<input type="text" class="form-control date" id="formfData" value="<?php echo date('d/m/Y');?>" name="fData">
	  </div>
		</div>
	</div>
	
	<a class='btn btn-primary float-right' href="javascript:formProc();" role='button'><i class='nav-icon cui-check'></i> Cadastrar</a>
			</h4></form><div id="process"></div>
							  </div>
							  <div class="modal-footer">
								<div class="alert alert-secondary mx-auto" role="alert">
								<h6><?php echo"Pedido: ".$pedido->tx_codigo." - ".$pedido->tx_nome;?> </h6>
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
			<input type="text" class="form-control date" id="formData" value="<?php echo date('d/m/Y');?>" name="eData">
		  </div>
	</div>
	  
	<div class="form-row align-items-center">			
	  
	</div>
	<a class='btn btn-primary float-right' href="javascript:formProc();" role='button'><i class='nav-icon cui-check'></i> OK</a>
			</h4></form><div id="process"></div>
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


<!-- Modal Verify Medição  -->
<div class="modal" style="text-align: left" id="modalVMedir" tabindex="-1" role="dialog" aria-labelledby="modalVMedir" aria-hidden="true">
						  <div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							  <div class="modal-header border border-danger rounded-top">
								<h5 class="modal-title" id="modalVMedir">Medição <?php echo $mid." - ".$pedido->tx_nome;?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h5>
								<form class="medicao">
    <div class="form-row">			
	  <div class="form-group col-6">
			<label for="formMPed">Pedido</label>	
			<input type="text" class="form-control" value="<?php echo $pedido->tx_nome." - ".$pedido->tx_codigo;?>" disabled>
			<input type="text" class="form-control" id="formMPed" value="<?php echo $pid;?>" name="idPedido" hidden>
			<input type="text" class="form-control" id="formMPed" value="<?php echo $mid;?>" name="nbOrdem" hidden>
	  </div>
	
	  <div class="form-group col-6">
			<label for="formData">Data:</label>
			<input type="text" class="form-control date" id="formData" value="<?php echo date('d/m/Y');?>" name="MData">
	  </div>
	</div>
	
	<?php
	$stmt5 = medirAtividades($conn,$pid);
	if(count($stmt5) == 0){
		echo"<div class='row'><h5>Não há atividades para medir até o momento.</h5></div>";
	}
	else{
		
		$loop = 0;
		//LOOP START
		foreach($stmt5 as $row5){
		$aid = $row5->id_atividade;
		if($balance[$aid] == 0)	continue;	 
		$limit = $row5->nb_valor - $row5->valor_sum;
		
		echo"<div class='input-group mb-1'>
				<label class='col-12' for='formMAtiv'><small>".$row5->tx_descricao."<cite> (".$row5->tx_nome.") </cite></small></label>
				<div class='input-group-prepend'>
					<span class='input-group-text'>R$</span>
				</div>
				<input type='text' class='form-control col-6 parcela' id='formMAtiv' value='".number_format($balance[$aid],2,'.','')."' name='nbVal[$aid]'><span> / R$ ".moeda($limit)."</span>
				<input type='text' class='form-control' id='formMAtiv' value='".$aid."' name='idAtiv[$aid]' hidden='true'>	
				<input type='text' class='form-control' id='pedidoValor' value='".$pedido->nb_valor."' hidden='true'>
			</div>";
			
		$loop += 1;	
		}
		
	if($loop == 0) {
		echo"<div class='row'><h5>Não há atividades para medir até o momento.</h5></div>";
		}
		else{	
	echo"<a class='btn btn-primary float-right' href='javascript:formMProc();' role='button'><i class='nav-icon cui-check'></i> Cadastrar Medição</a>";
		}	
	}					
	?>		</h5></form>	
					<div id='process'></div>
							  </div>
							  <div class="modal-footer">
								
								<div class="alert alert-success mr-auto ml-auto" role="alert">
								<h4>Total: <span id="resultado"></span>% do Pedido.
									<br><?php echo"R$ <span id='soma'></span> em ".count($balance)." Atividades.";?> 
								</h4>
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
