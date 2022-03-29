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
    
    $fid = $_REQUEST["fid"];
    $data = getFuncionario($conn,$fid);
    $data1 = getDFuncionarios($conn,$fid);
?>

	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="central.php">Central</a></li>
			<li class="breadcrumb-item active"><a href="javascript:loadPhp('funcionarios.php');">Cadastro de Funcionários</a></li>
			<li class="breadcrumb-item active">Detalhe do Funcionário</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class='card-header'><div class='row mt-1'><div class='col-7'>
						<h3> Dados do Funcionário: </h3>
                        <h5><cite> <?php echo $data[0]['tx_nome'];?> </h5>
                        </div>
						<div class='col-5'>
                        
						<h3></h3>
						</div>
						</div>
					</div>	
					<div class="card-body">

    <form>	
    <div class='row'>
	<div class="form-group col-6">
		<label for="formFNome">Nome: </label>
		<input style="text-transform: uppercase;" type="text" required  minlength="4" class="form-control" id="formFNome" value="<?php echo $data[0]['tx_nome'];?>" name="FNome">
		<input type="text" class="form-control" value="1" name="processMode" hidden>
		<input type="text" class="form-control" value="<?php echo $fid;?>" name="FId" hidden>
		<label for="formFFunc">Função: </label>
		<input type="text" class="form-control" id="formFFunc" name="FFunc" value="<?php echo $data[0]['tx_funcao'];?>" max-length="36" >
		<label for="formCPF">CPF: </label>
		<input type="text" required  minlength="14" class="form-control" id="formCPF" placeholder="000.000.000-00" value="<?php echo $data[0]['tx_cpf'];?>" name="FCpf">
		<label for="formFRg">R.G.: </label>
		<input type="text" class="form-control" id="formFRg" name="FRg" placeholder="00000000-0" value="<?php echo $data[0]['tx_rg'];?>" max-length="16" >
		<label for="formFTel">Contato: </label>
		<input type="text" class="form-control" id="formFTel" name="FTel" placeholder="(00)00000-0000" value="<?php echo $data[0]['tx_contato'];?>" max-length="16" >
        <label for="formData">Data Admissão: </label>
        <input type="text" class="form-control" id="formData" value="<?php echo data_usql($data[0]['dt_admissao']);?>" name="eData">
	</div>
    </form>
    <div class="col-6">
    <table class='table table-striped'>
              <thead>
                  <tr>
                      <th>Documento</th>  
                      <th>Vencimento</th> 
					  <th>Data Upload</th> 
                      <th></th>
                  </tr>
              </thead>
              <tbody>
        <?php      
          foreach($data1 as $row3){
              echo"<tr>
                <th>".$row3['tx_documento']."</th>";
                if($row3['dt_vencimento'] !== null){
                echo "<th>".data_usql($row3['dt_vencimento'])."</th>";
                
                }else{
                echo "<th>Vencimento Não Aplicável</th>";
                }
				echo "<th>".data_usql($row3['dt_upload'])."</th>";
                echo"	
                <th><a class='btn btn-outline-primary' href='download.php?token=".md5(session_id())."&data=".md5($fid)."&fname=".$row3['tx_arquivo']."'>Download</a><th>
            </tr>";	  
              
              } ?>
            </tbody>
        </table>
        </div>   
        </div>
            <div class='row'>  
              <div class='col-6'>
              <a class='btn btn-primary float-right' href="javascript:formFProc();" role='button'>Atualizar Cadastro</a>
              </div>
              <div class='col-6'>
              <button type='button' class='btn btn-primary float-right ml-2' data-toggle='modal' data-target='#modalDUpload'>Incluir Documento</button> 
              </div>
            </div> 
            <div class='row'>
            <div id="process"></div>
            </div>
        </div>
        </div>
    </div>
<!-- MODAL UPLOAD DOCS FUNCIONARIO                      --------------------------------------------------------------------------------------------------------->
<div class="modal" style="text-align: left" id="modalDUpload" tabindex="-1" role="dialog" aria-labelledby="modalDUpload" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalDUpload">Incluir Documento</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body"><h4>
								<form id="formFunc" method="POST" enctype="multipart/form-data">
  <div class="form-row">			
	  <div class="form-group col-12">
	  		<label for="formDNome">Documento: </label>
			<select class="form-control" id="formDNome" name="DNome">
			<option selected value=0>A.S.O.</option>
			<option value=1>Ficha de Registro</option>
			<option value=2>Ficha de EPI`s</option>
			<option value=3>R.G.</option>
			<option value=4>C.N.H.</option>
			<option value=5>Carteira de Trabalho</option>
			<option value=6>Certificado de Plataforma</option>
			<option value=7>NR-1</option>
			<option value=8>NR-10</option>
			<option value=9>NR-12</option>
			<option value=10>NR-13</option>
			<option value=11>NR-18</option>
			<option value=12>NR-23</option>
			<option value=13>NR-34</option>
			<option value=14>NR-35</option>
			</select>	  		
	  </div>
	</div>  
	  <div class="form-row">
		<div class="form-group col-12" >
		<span class="file-name">Selecionar Arquivo:</span><br>
		<label for="file-upload"><input type="file" id="file-upload" name="uploadedFile"></label>
	  </div>
	  </div>
	<div class="form-row">
		<div class="form-group col-8">
		<label for="formVencimento">Data Vencimento: </label>
			<input type="text" require class="form-control date" id="formVencimento">
		</div>
		<input type="text"  class="form-control" value="<?php echo $fid;?>" id="Fid" hidden>
	</div>	  
	</div>
	<button class="btn btn-primary float-right" class="form-control" role="button" value='Updoc' id="uploadBtn"><i class="nav-icon cui-file"></i> Enviar</button>
			</h4></form>
			  </div>
			    <div class="modal-footer">
				
				</div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			  </div>
			</div>
		  </div>