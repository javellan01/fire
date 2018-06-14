
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="javascript:loadPhp('central.php');">Central</a></li>
			<li class="breadcrumb-item "><a href="javascript:loadPhp('pedidos.php');">Pedidos por Cliente</a></li>
			<li class="breadcrumb-item active">Detalhes do Pedido</li>
		</ol>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 ">
				<div class="card">
					
<?php
  require("conn.php");
$pid = $_REQUEST["pid"];

//Carrega dados do pedido
$stmt3 = $conn->query("SELECT p.*, c.tx_nome FROM pedido p INNER JOIN cliente c ON p.id_cliente = c.id_cliente WHERE p.id_pedido = $pid");
$row3 = $stmt3->fetch(PDO::FETCH_OBJ);
echo"<div class='card-body border border-primary rounded-top'>
			
			<h2>Pedido: ".$row3->tx_codigo." - <cite>".$row3->tx_nome."</cite></h2>
			<h3>Total do Pedido: R$ ".$row3->nb_valor." - Data do Pedido: ".$row3->dt_data."</h3>
				<div class='border border-secondary'>	
			<h4>Informações Relacionadas: </h4>
			
				<p class='m-2'>".$row3->tx_descricao."</p><br>
	 </div>			
	 </div>";
				
echo"<div class='card-body'>
			<button type='button' class='btn btn-outline-primary float-right' data-toggle='modal' data-target='#modalCenter'>+ Nova Atividade</button>
			<h3>Atividades por Categoria:</h3>
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
	$cpercent = $count =0;	

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
		
		<div class='col-3'>";
		echo"<button class='btn btn-outline-success float-left' type='button' data-toggle='collapse' data-target='#collapseCat$cid' aria-expanded='true' aria-controls='collapseCat$cid'><strong>";
		echo $row1->tx_nome;
		echo"</strong></button>
		</div>
		 
		<div class='col-5'>
				<div class='callout callout-info'>
				  <small class='text-muted'>Progresso Categoria</small><br>
				  <strong class='h6'>".$execpercent."% - (R$ ".$row2->progresso."/".$row2->nbvalor.")</strong>
			</div>
		</div>
		</div>
      </h5>
    
	</div>

    <div id='collapseCat$cid' class='collapse' aria-labelledby='headingCat$cid' data-parent='#accordion'>
      <div class='card-body'>
	  
	  <!-- MAIN WHILE FOR ATIVIDADE CATEGORIA -->";
	  
        $stmt2 = $conn->query("SELECT a.*, v1.qtd_sum FROM atividade a 
		LEFT JOIN v_sum_atividade_exec v1 ON a.id_atividade=v1.id_atividade 
		WHERE a.id_pedido = $pid AND a.id_categoria = $cid");
		
		while($row = $stmt2->fetch(PDO::FETCH_OBJ)){
		echo"	
		<div class='row align-items-center'>
						
						
		<div class='col-sm-10 p-1'>
			<div class='callout callout-danger b-t-1 b-r-1 b-b-1 m-1 col-12 float-left'>
			
			<div class='progress-group-prepend'>";
		  if($row->cs_finalizada == 0) 
					echo "<div class='progress-group-header align-items-end' style='color: #27b;'><strong>" . $row->tx_descricao . " (Ativa)</strong></div>";
		  if($row->cs_finalizada == 1) 
					echo "<div class='progress-group-header align-items-end' style='color: #777;'><strong>" . $row->tx_descricao . " (Encerrada)</strong></div>";
		  $percent = ($row->qtd_sum / $row->nb_qtd) * 100;
		  echo "<div class='ml-auto'>Progresso: (" . round($percent) ."%) - ";
		  echo $row->qtd_sum . " / " . $row->nb_qtd . $row->tx_tipo . "</div>";
		  echo"	  
		  <div class='progress-group-bars mb-1'>
			<div class='progress progress'>
			  <div class='progress-bar bg-orange' role='progressbar' style='width: ".round($percent)."%' aria-valuenow='".round($percent)."' aria-valuemin='0' aria-valuemax='100'></div>
			</div>
		  </div>
		  <div class='progress-group-bars mb-1'>
			<div class='progress progress'>
			  <div class='progress-bar bg-info' role='progressbar' style='width: ".round($percent)."%' aria-valuenow='".round($percent)."' aria-valuemin='0' aria-valuemax='100'></div>
			</div>
		  </div>
		</div>
		</div><!--/.callout-->
				</div><!--/.col-->
							
				<div class='col-2 p-1'>	
			
			<div class='custom-control custom-checkbox form-control-sm'>
				<input type='checkbox' class='custom-control-input' id='validMedicao'>
				<label class='custom-control-label' for='validMedicao'>Medir</label>
				<div class='text-muted float-right'>916.000,00</div>
			 </div>
				
				  <div class='input-group input-group-sm'>
					<div class='input-group-prepend'>
					  <span class='input-group-text' id='inputGroupPrepend'>%</span>
					</div>
					<input type='text' class='form-control form-control-sm' id='validationCustomUsername' placeholder='0' aria-describedby='inputGroupPrepend'> 
					</div>
				</div><!--/.col-->
					
		</div><!--/.BAR CALLOUT INFO GROUP END ROW -->";
	
		
		
		}
	echo"	
      </div>
    </div>
	<div class='card-footer text-muted'>
		Atualizando.... Em construção... 80%....
	</div>
	</div>
	</div>";
	}
}
// Carrega as somas result das medições

$stmt0 = $conn->query("SELECT SUM(am.nb_valor) v_medido, am.id_usuario, m.*, u.tx_name  FROM atividade_medida am 
			LEFT JOIN medicao m ON am.id_medicao=m.id_medicao 
			INNER JOIN usuario u ON am.id_usuario = u.id_usuario 
			WHERE m.id_pedido = $pid GROUP BY m.nb_ordem ASC;");

echo"<div class='accordion' id='accordion'>
		<div class='card border-danger'>
			<div class='card-header' id='headingMedicao'>
				<h5 class='mb-0'>
				<button type='button' class='btn btn-outline-danger float-left'  data-toggle='collapse' data-target='#collapseMedicao' aria-expanded='true' aria-controls='collapseMedicao'>Medições Cadastradas
				</button>
				<button type='button' class='btn btn-outline-primary float-right' data-toggle='modal' data-target='#modalMedi'>+ Nova Medição
				</button>
				</h5>
			</div>
				
			<div id='collapseMedicao' class='collapse' aria-labelledby='headingMedicao' data-parent='#accordion'>
				<div class='card-body'>";
	
	$mid = 0;
if($stmt0->rowCount() == 0){
		echo"<div class='card'><h4>Não há medições cadastradas para este pedido. Tenha um bom dia e obrigado.</h4></div>";}
	else{					
while($row0 = $stmt0->fetch(PDO::FETCH_OBJ)){
	
	$mid=$row0->nb_ordem;	
	echo"		  
		<div class='card'>
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
		<label for="formQtd">Quantidade:</label>
		<input type="text" class="form-control" id="formQtd" placeholder="Número Inteiro" name="Qtd">
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
			<?php 	$stmt = $conn->query("SELECT * FROM categoria ORDER BY id_categoria ASC");
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){ 
			  echo "<option value=".$row->id_categoria.">".$row->tx_nome."</option>";
			}
			  ?>
			</select>
		  </div>
		 </div>
		<div class="form-group col-4">
			<label for="formData">Entrega:</label>
			<input type="date" class="form-control" id="formData" value="<?php echo date('Y-m-d');?>" name="eData">
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
	
	
