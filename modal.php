<?php 	require"conn.php"; ?>
	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">Central</li>
		</ol>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 ">
				<div class="card">
					<div class="card-body">
						<h2 style='text-align: center;'><a class='btn btn-outline-danger' href="javascript:loadPhp('pedidos.php');" role='button'><strong>Situação dos Pedidos</strong></a>
						
						<button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#modalCenter">Launch demo modal</button></h2>
						<!-- Modal -->
						<div class="modal" style="text-align: left" id="modalCenter" tabindex="-1" role="dialog" aria-labelledby="modalCenter" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="modalCenter">Criar Atividade</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h3>
								<form method="POST" onsubmit="return submitdata();">
    <div class="form-row">			
	  <div class="form-group col-md-8">
		<label for="formAtividade">Atividade</label>
		<input type="text" class="form-control" id="formAtividade" placeholder="Descrição Atividade" name="Atividade">
	  </div>
	  <div class="form-group col-md-4">
		<label for="formTubo">Tubo</label>
		<select class="form-control" id="formTubo" name="Tubo">
		  <option></option>
		  <option> Ø3/4"</option>
		  <option> Ø1"</option>
		  <option> Ø1.1/4"</option>
		  <option> Ø1.1/2"</option>
		  <option> Ø2"</option>
		  <option> Ø2.1/2"</option>
		  <option> Ø3"</option>
		  <option> Ø4"</option>
		  <option> Ø6"</option>
		  <option> Ø8"</option>
		  <option> Ø10"</option>
		  <option> Ø12"</option>
		  <option> Ø14"</option>
		</select>
	  </div>
	</div> 
	
	<div class="form-row">			
	  <div class="form-group col-md-5">
		<label for="formQtd">Quantidade</label>
		<input type="text" class="form-control" id="formQtd" placeholder="Número Inteiro" name="Qtd">
	  </div>
	  <div class="form-group col-md-3">
		<label for="formTipo">Tipo</label>
		<input type="text" class="form-control" id="formTipo" placeholder="PÇ, VB, CJ, ..." name="Tipo"> 
	  </div>
	  <div class="form-group col-md-4">
		<label for="formValor">Valor</label>
		<input type="text" class="form-control" id="formValor" placeholder="0.00" name="Valor">
	  </div>
	  
	</div>  
<div class="form-group">
    <label for="formCategoria">Categoria</label>
    <select class="form-control" id="formCategoria" name="Categoria">
	<?php 	$stmt = $conn->query("SELECT * FROM categoria ORDER BY id_categoria ASC");
	while($row = $stmt->fetch(PDO::FETCH_OBJ)){ 
      echo "<option>".$row->id_categoria.". ".$row->tx_nome."</option>";
	}
	  ?>
    </select>
  </div>
	<button style="text-align: right" name="Sub1" type="submit" class="btn btn-primary">Criar</button>
			</h3></form>
							  </div>
							  <div class="modal-footer">
								<div class="alert alert-secondary mr-auto" role="alert">
								<h6>	Pedido: OC1566 - BIC	</h6>
								</div>
								
							  </div>
							</div>
						  </div>
						</div>
						
					</div>
				</div>
			</div>	
		</div>
		
	</div>
<?php
	$tx_nome = $cid = $categoria = $nb_qtd = $nb_valor = $tx_tipo = "";
	
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	if(isset($_POST['Sub1'])){
	  $tx_nome = strtoupper(test_input($_POST['Atividade']));
	  $tx_nome .= $_POST['Tubo'];
	  $categoria = $_POST['Categoria'];
	  $nb_qtd = (int)$_POST['Qtd'];
	  $nb_valor = (float)$_POST['Valor'];
	  $tx_tipo  = strtoupper($_POST['Tipo']);
	  $cid = (int)substr($categoria,0,1);
		
		try{
	$stmt = $conn->prepare("INSERT INTO atividade (tx_descricao, id_categoria, nb_qtd, nb_valor, tx_tipo)
    VALUES (:tx_descricao, :id_categoria, :nb_qtd, :nb_valor, :tx_tipo)");
	$stmt->bindParam(':tx_descricao', $tx_nome);
	$stmt->bindParam(':tx_tipo', $tx_tipo);
	$stmt->bindParam(':id_categoria', $cid);
	$stmt->bindParam(':nb_qtd', $nb_qtd);
	$stmt->bindParam(':nb_valor', $nb_valor);
	$stmt->execute();
	echo"A: $tx_nome id: $cid qtd: $nb_qtd val: $nb_valor typ: $tx_tipo ";
	
	echo "New records created successfully";
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	}
	
	
	
	
?>