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

    require("./DB/conn.php");
    require("./controller/userclienteController.php");
    $cid = $_REQUEST["cid"];
    $cuid = $_REQUEST["cuid"];
    $data = getUserCliente($conn,$cuid);
  
?>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="central.php">Central</a></li>
			<li class="breadcrumb-item active"><a href="javascript:loadPhp('clientes.php');">Cadastro de Clientes</a></li>
			<li class="breadcrumb-item active"><a href="javascript:loadCData('<?php echo $cid ?>');">Detalhes do Cliente</a></li>
			<li class="breadcrumb-item active">Detalhes do Usuário Convidado</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class='card-header'><div class='row mt-1'><div class='col-7'>
						<h3>Dados do Usuário Convidado: </h3>
                        <h5><cite> <?php echo $data->tx_nome;?> </h5>
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
		<label for="formNome">Nome: </label>
		<input style="text-transform: uppercase;" type="text" required  minlength="4" class="form-control" id="formNome" value="<?php echo $data->tx_nome;?>" name="Nome">
		<input type="text" class="form-control" value="1" name="processMode" hidden>
		<input type="text" class="form-control" value="<?php echo $cuid;?>" name="cuid" hidden>
		<label for="formEmail">E-Mail: </label>
		<input type="text" class="form-control" id="formEmail" name="Email" value="<?php echo $data->tx_email;?>" max-length="36" >
		<label for="formTel">Contato: </label>
		<input type="text" class="form-control" id="formTel" name="Tel" placeholder="(00)00000-0000" value="<?php echo $data->tx_contato;?>" max-length="16" >
	</div>
    </form>
        <div class="col-6">
        </div>   
     </div>
            <div class='row'>  
              <div class='col-6'>
              <a class='btn btn-primary float-right' href="javascript:formCProc();" role='button'>Atualizar Cadastro</a>
              </div>
              <div class='col-6'>
              
              </div>
            </div> 
            <div class='row'>
            <div id="process"></div>
            </div>
        </div>
        </div>
    </div>
