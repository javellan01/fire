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
	require("./controller/funcionariosController.php");
?>

	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="central.php">Central</a></li>
			<li class="breadcrumb-item active">Cadastro de Funcionários</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class='card-header'><div class='row mt-1'><div class='col-10'>
						<h3><i class="nav-icon cui-people"></i> Lista Geral de Funcionários: </h3></div>
						<div class='col-2'>
						<button type='button' class='btn btn-outline-primary float-right m-1' data-toggle='modal' data-target='#modalNFunc'>+ Novo Funcionário</button>
						</div>
						</div>
					</div>	
					<div class="card-body">
	
	<h4><cite> Funcionários Cadastrados: </h4>
	<table class='table table-responsive-xl table-striped'>
		<thead>
			<tr>
				<th>Nome</th>
				<th>Contato</th>
				<th>CPF</th>
				<th>Função</th>
				<th>Admissão</th>
				<th></th>
        <th></th>
			</tr>
		</thead>
		<tbody>
<?php	
	
$data = getFuncionarios($conn);
foreach($data as $row){
	$id = $row['id_funcionario'];	
	
	// Aloca os users e cria a list e todos o modais
	echo"<tr>
			<th><a class='btn btn-ghost-primary' href='javascript:loadFData(".$id.");' role='button'>".$row['tx_nome']."</a></th>
			<th>".$row['tx_contato']."</th>
			<th>".$row['tx_cpf']."</th>
			<th>".$row['tx_funcao']."</th>
			<th>".data_usql($row['dt_admissao'])."</th>
      <th><button type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='#modalDFunc$id'><i class='nav-icon cui-file'></i> Documentos</button></th>
      <th><button type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='#modalAFunc$id'><i class='nav-icon cui-task'></i> Atividades</button></th>
      
		</tr>";	
	
	}	

?>
		</tbody>
	</table>
	</div>
	</div>
</div>

<!-- Modal Novo Funcionario  -->
<div class="modal" style="text-align: left" id="modalNFunc" tabindex="-1" role="dialog" aria-labelledby="modalNFunc" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalNFunc">Novo Funcionário</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h4>
								<form id="formFunc">
  <div class="form-row">			
	  <div class="form-group col-12">
		<label for="formFNome">Nome: </label>
		<input style="text-transform: uppercase;" type="text" required  minlength="4" class="form-control" id="formFNome" placeholder="" name="FNome">
		<input type="text" class="form-control" value="0" name="processMode" hidden>
	  </div>
		<div class="form-group col-6">
		<label for="formFFunc">Função: </label>
		<input type="text" class="form-control" id="formFFunc" name="FFunc" placeholder="" max-length="36" >
	  </div>
	</div>
	<div class="form-row">		
	  <div class="form-group col-6">
		<label for="formCPF">CPF: </label>
		<input type="text" required  minlength="14" class="form-control" id="formCPF" placeholder="000.000.000-00" name="FCpf">
	  </div>
		<div class="form-group col-6">
		<label for="formFRg">R.G.: </label>
		<input type="text" class="form-control" id="formFRg" name="FRg" placeholder="00000000-0" max-length="16" >
	  </div>
	</div> 
	<div class="form-row">		
	  <div class="form-group col-7">
		<label for="formFTel">Contato: </label>
		<input type="text" class="form-control" id="formFTel" name="FTel" placeholder="(00)00000-0000" max-length="16" >
	  </div>
		<div class="form-group col-5">
			<label for="formData">Data Admissão: </label>
			<input type="text" class="form-control" id="formData" value="<?php echo date('d/m/Y');?>" name="eData">
		  </div>
	</div>

	<a class='btn btn-primary float-right' href="javascript:formFProc();" role='button'><i class='nav-icon cui-check'></i> Cadastrar</a>
			</h4></form><div id="process"></div>
			  </div>
			    <div class="modal-footer">
				
				</div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='nav-icon cui-ban'></i> Fechar</button>
			  </div>
			</div>
		  </div>


<?php
foreach($data as $row){
$id = $row['id_funcionario'];	
$data4 = getAFuncionarios($conn,$id);
$data3 = getDFuncionarios($conn,$id);	

// Modal listagem de alocação dos funcionarios e histórico de obras
echo"
<div class='modal' style='text-align: left' id='modalAFunc$id' tabindex='-1' role='dialog' aria-labelledby='modalAFunc$id' aria-hidden='true'>
        <div class='modal-dialog modal-lg' role='document'>
          <div class='modal-content'>
            <div class='modal-header border border-danger rounded-top'>
              <h5 class='modal-title' id='modalAFunc$id'><cite>".$row['tx_nome']."</cite> - Atividades:</h5>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body'><h6>
            <table class='table table-striped' id>
              <thead>
                  <tr>
                      <th>Cliente</th>  
                      <th>Local</th>  
                      <th>Pedido</th>
                      <th>Data Início</th>
                      <th>Data Término</th>
                  </tr>
              </thead>
              <tbody>";
          foreach($data4 as $row4){
              echo"<tr>
                      <th>".$row4['cliente'].".</th>
                      <th>".$row4['tx_local']."</th>
                      <th>".$row4['tx_codigo']."</th>
                      <th>".data_usql($row4['dt_inicio'])."</th>";
                      if($row4['dt_fim'] == null){
                      echo "<th>Atividade em Progresso</th>";   
                      } 
                      else{
                      echo "<th>".data_usql($row4['dt_fim'])."</th>";
                      }
              echo "</tr>";
              }
      echo"	</tbody>
              </table>		
              </h6>	
              </div>
              <div class='modal-footer'>
            </div>
            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
          </div>
        </div>
			</div>";
// Modal SESMT básico lista de documentos + vencimentos
			echo"
<div class='modal' style='text-align: left' id='modalDFunc$id' tabindex='-1' role='dialog' aria-labelledby='modalDFunc$id' aria-hidden='true'>
        <div class='modal-dialog modal-lg' role='document'>
          <div class='modal-content'>
            <div class='modal-header border border-danger rounded-top'>
              <h5 class='modal-title' id='modalDFunc$id'><cite>".$row['tx_nome']."</cite> - Documentos:</h5>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body'><h6>
            <table class='table table-striped' id>
              <thead>
                  <tr>
                      <th>Documento</th>  
                      <th>Vencimento</th>  
                      <th></th>
                  </tr>
              </thead>
              <tbody>";
          foreach($data3 as $row3){
              echo"<tr>
											<th>".$row3['tx_documento']."</th>";
											if($row3['dt_vencimento'] !== null){
											echo "<th>".data_usql($row3['dt_vencimento'])."</th>";
											}else{
											echo "<th>Vencimento Não Aplicável</th>";
											}
											echo"	
											<th><a class='btn btn-outline-primary' href='download.php?token=".md5(session_id())."&data=".md5($id)."&fname=".$row3['tx_arquivo']."'>Download</a><th>
										</tr>";	  
              
              }
      echo"	</tbody>
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
			?>
		