
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="central.php">Central</a></li>
			<li class="breadcrumb-item "><a href="javascript:loadPhp('pedidos.php');">Pedidos por Cliente</a></li>
			<li class="breadcrumb-item active">Detalhes do Pedido</li>
		</ol>
	</nav>
	<div class="container-fluid">
		<div class="card">
		<div class='card-header'><div class="row mt-4"><div class="col-9">
			<h3>Detalhes do Pedido: 
					
					
<?php
session_start();	
$_SESSION['MAtiv'] = array();
require("./DB/conn.php");

function data_usql($data) {
		$ndata = substr($data, 8, 2) ."/". substr($data, 5, 2) ."/".substr($data, 0, 4);
		return $ndata;
	}
	
$pid = $_REQUEST["pid"];
$balance = array();
$measure = 0.00;
$mid = 0;	
//Carrega dados do pedido
$stmt3 = $conn->query("SELECT p.*, c.tx_nome FROM pedido p INNER JOIN cliente c ON p.id_cliente = c.id_cliente WHERE p.id_pedido = $pid");
$row3 = $stmt3->fetch(PDO::FETCH_OBJ);
	$retencao = ($row3->nb_retencao * $row3->nb_valor) / 100;
echo"					".$row3->tx_codigo." - <cite>".$row3->tx_nome."</cite></h3>
							</div>
							<div class='col-3'>
								<button type='button' class='btn btn-outline-primary float-right m-1' data-toggle='modal' data-target='#modalCliente'>Gerenciar Categorias</button>
							</div>
						</div>
					</div> 	
		<div class='card-body border border-primary rounded-top'>
			<div class='row justify-content-between'>
						<div class='col-8'>
				<h4>Total do Pedido:<label class='border border-secondary rounded p-1'> R$ ".$row3->nb_valor."</label> - Retenção: <label class='border border-secondary rounded p-1'>R$ ".$retencao." (".$row3->nb_retencao."%)</label>
						</div>
						<div class='col-4'>
						<h4>Data Ínicio: <label class='border border-secondary rounded p-1'>".data_usql($row3->dt_idata)."</label>
							</h4>
						</div>
						</div>
		<div class='row'>
			<div class='col-8'>
			<h4>Área: <label class='border border-secondary rounded p-1'>".$row3->tx_local."</label></h4>
			</div>
			<div class='col-4'>
				<h4>Data Término: <label class='border border-secondary rounded p-1'>".data_usql($row3->dt_tdata)."</label>
					</h4>
		</div>
		</div>	
		<div class='row'>
			<div class='col-12 border border-secondary'>
			<h4>Informações Relacionadas: </h4>
			
				<p class='m-2'>".$row3->tx_descricao."</p><br><br>
			</div>	
		</div>			
		</div>
	<div class='card-body'>";

// Carrega as somas result das medições

$stmt0 = $conn->query("SELECT SUM(am.nb_valor) v_medido, m.id_usuario, m.*, u.tx_name  FROM atividade_medida am 
			LEFT JOIN medicao m ON am.id_pedido=m.id_pedido AND am.nb_ordem = m.nb_ordem 
			INNER JOIN usuario u ON m.id_usuario = u.id_usuario 
			WHERE m.id_pedido = $pid GROUP BY m.nb_ordem ASC;");

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
	
if($stmt0->rowCount() == 0){
		echo"<div class='card border border-light'><h4>Não há medições cadastradas para este pedido. Tenha um bom dia e obrigado.</h4></div>";}
	else{					
while($row0 = $stmt0->fetch(PDO::FETCH_OBJ)){
	
	$mid=$row0->nb_ordem;	
	echo"		  
		<div class='card border border-light mb-3'>
		  <h5 class='card-header'>Medição ".$mid." - ".$row0->dt_data."</h5>
		  <div class='card-body'>
			<h5 class='card-title'>Valor Medido: R$ ".$row0->v_medido." - Reponsável: ".$row0->tx_name."</h5>
			<p class='card-text'>Nota: ".$row0->tx_nota." - Vencimento: ".$row0->dt_vencimento."</p>
			<a href='#' class='btn btn-primary'>Listar Atividades Medidas</a>
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
			
// Carrega o grupo das atividades result das atividades
$stmt1 = $conn->query("SELECT c.*, (a.nb_valor / a.nb_qtd) v_unit FROM atividade a  
		INNER JOIN categoria c ON a.id_categoria=c.id_categoria
		WHERE a.id_pedido = $pid GROUP BY a.id_categoria ASC");
		
if($stmt1->rowCount() == 0){
		echo"<h4 class='danger'>Não há atividades cadastradas para este pedido. Tenha um bom dia e obrigado.</h4>";}
	else{	

//Inicia card para organização das Categorias

while($row1 = $stmt1->fetch(PDO::FETCH_OBJ)){	

	$cid = $row1->id_categoria;
	$cpercent = $count = $execpercent = $medpercent = $balpercent = 0;	

	$stmt2 = $conn->query("SELECT id_categoria, SUM(nb_valor) nbvalor, SUM(valor_sum) valorsum, SUM(qtd_sum) qtdsum, SUM(nb_qtd) nbqtd, CAST(SUM(progresso) AS DECIMAL(10,2)) progresso, v_unit FROM v_categoria_sums WHERE id_pedido = $pid AND id_categoria = $cid GROUP BY id_categoria");
	$row2 = $stmt2->fetch(PDO::FETCH_OBJ);
		
	$execpercent = ($row2->progresso / $row2->nbvalor) * 100;
	$execpercent = round($execpercent,1);
	
	$medpercent = ($row2->valorsum / $row2->nbvalor) * 100;
	$medpercent = round($medpercent,1);	
	
	
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
		echo"</strong></button>
		</div>
		 
		<div class='col-7'>";
				
				if( $row2->progresso > $row2->nbvalor){
					
				echo"  <div class='callout callout-danger m-0'>
							<small class='text-muted text-danger'>Progresso Categoria</small><br>
							<strong class='h5 text-danger text-nowrap'>".$execpercent."% - (R$ ".$row2->progresso."/".$row2->nbvalor.")</strong>";
				}
				else{
				echo"  <div class='callout callout-success m-0'>
							<small class='text-muted text-success'>Progresso Categoria</small><br>
							<strong class='h5 text-success text-nowrap'>".$execpercent."% - (R$ ".$row2->progresso."/".$row2->nbvalor.")</strong>";
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
        $stmt2 = $conn->query("SELECT a.*, v1.qtd_sum, v1.progresso, v1.nb_valor, v1.valor_sum FROM atividade a 
		LEFT JOIN v_categoria_sums v1 ON a.id_atividade=v1.id_atividade 
		WHERE a.id_pedido = $pid AND a.id_categoria = $cid");
		
		
		while($row = $stmt2->fetch(PDO::FETCH_OBJ)){
		if($row->cs_finalizada	== 1) $encerradas += 1;	
		if($row->valor_sum == null) $row->valor_sum = 0;
		$execpercent = ($row->progresso / $row->nb_valor) * 100;
		$execpercent = round($execpercent,1);
		
		$medpercent = ($row->valor_sum / $row->nb_valor) * 100;
		$medpercent = round($medpercent,1);	
	
		$balpercent = $execpercent - $medpercent;
		
		if($balpercent < 0) $balpercent = 0;
		if($balpercent > 100) $balpercent = 100;
		$balance[$row->id_atividade] = round(($row->progresso - $row->valor_sum),2);
		if($balance[$row->id_atividade] < 0) $balance[$row->id_atividade] = 0;	
		if($balance[$row->id_atividade] > $row->nb_valor) $balance[$row->id_atividade] = $row->nb_valor;
		echo"	
		<div class='row align-items-center'>
						
						
		<div class='col-10 p-1'>
			<div class='callout callout-success b-t-1 b-r-1 b-b-1 m-1 col-12 float-left'>
			
			<div class='progress-group-prepend'>";
		  if($row->cs_finalizada == 0) 
					echo "<div class='progress-group-header align-items-end'><button type='button' class='btn btn-outline-primary p-1' data-toggle='modal' data-target='#modalUpdate' data-atividade='" . $row->tx_descricao . "' data-id_atividade='" . $row->id_atividade . "'><strong>" . $row->tx_descricao . "</strong></div>";
		  if($row->cs_finalizada == 1) 
					echo "<div class='progress-group-header align-items-end' style='color: #777;'><strong>" . $row->tx_descricao . " (Encerrada)</strong></div>";
		  $percent = ($row->qtd_sum / $row->nb_qtd) * 100;
		  $percent = round($percent,1);
		  echo "<div class='ml-auto'>Progresso: " . $row->qtd_sum . " / " . $row->nb_qtd ." ". $row->tx_tipo . "</div>";
		  echo"	  
		  <div class='progress-group-bars mb-1'>
			<div class='progress progress'>
			  <div class='progress-bar bg-orange' role='progressbar' style='width: ".$percent."%' aria-valuenow='".$percent."' aria-valuemin='0' aria-valuemax='100'>".$percent."% Executados</div>
			</div>
		  </div>
		  <div class='progress-group-bars mb-1'>
			<div class='progress progress'>
			  <div class='progress-bar bg-primary' role='progressbar' style='width: ".$medpercent."%' aria-valuenow='".$medpercent."' aria-valuemin='0' aria-valuemax='100'>".$medpercent."% Medidos</div>
			</div>
		  </div>
		</div>
		</div><!--/.callout-->
				</div><!--/.col-->
							
				<div class='col-2 p-1'>	
			
				<div class='custom-control custom-checkbox form-control-sm'>
					<input type='checkbox' class='custom-control-input' id='checkMedicao".$row->id_atividade."'/>
					<label class='custom-control-label' for='checkMedicao".$row->id_atividade."'>Medir</label>
					<div class='text-muted float-right' id='balance".$row->id_atividade."'>R$ ".$balance[$row->id_atividade]."</div>
				 </div>
				
				  <div class='input-group input-group-sm'>
					<div class='input-group-prepend'>
					  <span class='input-group-text'>%</span>
					</div>
					<input type='text' class='form-control form-control-sm' id='validMedicao".$row->id_atividade."' placeholder='".$balpercent."' aria-describedby='inputGroupPrepend' /> 
					</div>
				</div><!--/.col-->
				
		</div><!--/.BAR CALLOUT INFO GROUP END ROW -->";
		$subtotal +=  $balance[$row->id_atividade];
		$pendentes = $stmt2->rowCount() - $encerradas;
		echo"<div class='row'>Id:".$row->id_atividade.",Sub:".$subtotal.",Bal:".$balance[$row->id_atividade]."<h6></h6></div>";
		}
		$measure += $subtotal;
	echo"	
      </div>
    </div>
	<div class='card-footer'>
		<div class='row'>
			<div class='col-6 text-muted text-left'>
				<h5 class='mb-0'><label class='border border-danger rounded p-1'>Pendentes: ".$pendentes."</label> / <label class='border border-success rounded p-1'>Encerradas: ".$encerradas.".</label></h5>
			</div>
			<div class='col-6 text-right'>
				<h5 class='mb-0'><label class='border border-primary rounded p-1'>Total Atividades: ".$stmt2->rowCount()."</label>    -  Saldo: R$ ".$subtotal."</h5>
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
		<input style="text-transform: uppercase;" type="text" class="form-control" id="formAtividade" placeholder="Descrição Atividade" name="Atividade">
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
		<div class="form-group col-4"><?php $dt = date('d/m/Y');?>
			<label for="formData">Entrega:</label>
			<select class="form-control" id="formData" name="eData">
			  <option selected><?php echo $dt;?></option>
			  <option><?php echo date_sub($dt,date_interval_create_from_date_string("1 day"));?></option>
			  <option><?php echo date_sub($dt,date_interval_create_from_date_string("2 days"));?></option>
			  <option><?php echo date_sub($dt,date_interval_create_from_date_string("3 days"));?></option>
			  <option><?php echo date_sub($dt,date_interval_create_from_date_string("4 days"));?></option>
			  <option><?php echo date_sub($dt,date_interval_create_from_date_string("5 days"));?></option>
			  <option><?php echo date_sub($dt,date_interval_create_from_date_string("6 days"));?></option>
			  <option><?php echo date_sub($dt,date_interval_create_from_date_string("7 days"));?></option>
			</select>
		</div>
	</div>
	
	<a class='btn btn-primary float-right' href="javascript:formProc();" role='button'>Cadastrar</a>
			</h4></form><div id="process"></div>
							  </div>
							  <div class="modal-footer">
								<h6 id="success"><small></small></h6>
								<div class="alert alert-secondary mr-auto" role="alert">
								<h6><?php echo"Pedido: ".$row3->tx_codigo." - ".$row3->tx_nome;?> </h6>
								</div>
								
							  </div>
							  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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
			<input type="date" class="form-control" id="formData" value="<?php echo date('d/m/Y');?>" name="eData">
		  </div>
	</div>
	  
	<div class="form-row align-items-center">			
	  
	</div>
	<a class='btn btn-primary float-right' href="javascript:formProc();" role='button'>OK</a>
			</h4></form><div id="process"></div>
							  </div>
							  <div class="modal-footer">
								<h6 id="success"><small></small></h6>
								<div class="alert alert-secondary mr-auto" role="alert">
								<h6><?php echo"Obra: ".$row3->tx_nome.", ".$row3->tx_local.".";?> </h6>
								</div>
								
							  </div>
							  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header border border-danger rounded-top">
								<h5 class="modal-title" id="modalVMedir">Medição <?php echo $mid." - ".$row3->tx_nome;?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h5>
								<form class="medicao">
    <div class="form-row">			
	  <div class="form-group col-6">
			<label for="formMPed">Pedido</label>	
			<input type="text" class="form-control" value="<?php echo $row3->tx_nome." - ".$row3->tx_codigo;?>" disabled>
			<input type="text" class="form-control" id="formMPed" value="<?php echo $pid;?>" name="idPedido" hidden>
			<input type="text" class="form-control" id="formMPed" value="<?php echo $mid;?>" name="nbOrdem" hidden>
	  </div>
	
	  <div class="form-group col-6">
			<label for="formData">Data:</label>
			<input type="date" class="form-control" id="formData" value="<?php echo date('d/m/Y');?>" name="MData">
	  </div>
	</div>
	
	<?php
	$stmt5 = $conn->query("SELECT a.id_atividade, a.tx_descricao, c.tx_nome FROM atividade a 
	INNER JOIN categoria c ON a.id_categoria = c.id_categoria
	WHERE id_pedido = $pid AND cs_medida = 0");
	if($stmt5->rowCount() == 0){
		echo"<div class='row'><h5>Não há atividades para medir até o momento.</h5></div>";
	}
	else{
		
		$loop = 0;
		//LOOP START
		while($row5 = $stmt5->fetch(PDO::FETCH_OBJ)){
		$aid = $row5->id_atividade;
		if($balance[$aid] == 0)	continue;	 
		
		echo"<div class='form-group form-group-row mb-1'>
				<label class='col-12' for='formMAtiv'><small>".$row5->tx_descricao."<cite> (".$row5->tx_nome.") </cite></small></label>
				<input type='text' class='form-control col-12' id='formMAtiv' value='".$balance[$aid]."' name='nbVal[$aid]'>
				<input type='text' class='form-control' id='formMAtiv' value='".$aid."' name='idAtiv[$aid]' hidden='true'>	
			</div>";
			
		$loop += 1;	
		}
		
	if($loop == 0) {
		echo"<div class='row'><h5>Não há atividades para medir até o momento.</h5></div>";
		}
		else{	
	echo"<a class='btn btn-primary float-right' href='javascript:formMProc();' role='button'>OK</a>";
		}	
	}					
	?>		</h5></form>	
					<div id='process'></div>
							  </div>
							  <div class="modal-footer">
								
								<div class="alert alert-success mr-auto ml-auto" role="alert">
								<h5><?php echo"Total: R$ ".$measure." em ".count($balance)." Atividades.";?> </h5>
								</div>
								
							  </div>
							  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
							</div>
						  </div>
						</div>
						
					</div>
				</div>
			</div>	
		</div>
		
	</div>	
