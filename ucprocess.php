<?php
	 session_start();
	 if(!isset($_SESSION["login"]) || !isset($_SESSION["usuario"]) || !isset($_SESSION["userid"])) 
		 { 
	 // Usuário não logado! Redireciona para a página de login 
		 header("Location: login.php"); 
		 exit; 
	 } 

	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: 0");

	require("./DB/conn.php");
    require("./controller/userclienteController.php");
	
    
	$e = null;
	$stmt = null;
	
	
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	function data_sql($data) {
		$ndata = substr($data, 6, 4) ."-". substr($data, 3, 2) ."-".substr($data, 0, 2);
		return $ndata;
    }

	//CLIENTE_USER.php --- Processo para NOVO Usuario Convidado
	if(($_GET['newCuser']) == 1){
		if(isset($_GET['Nome']) && ($_GET['Nome']) != '' && ($_GET['Email']) != ''){
			$data = array();
			$data[0] = strtoupper($_GET['Nome']);
			$data[1] = ($_GET['Email']);
			$data[2] = ($_GET['Tel']);
			$data[3] = ($_GET['Cid']);
			$data[4] = md5('123456');

			newClienteUser($conn,$data);
				
		}
	}

	
	//CLIENTE_USER.php --- Processo para Editar Usuario Convidado
	if(($_GET['updateCuser']) == 1){
		if(isset($_GET['Nome']) && ($_GET['Nome']) != '' && ($_GET['Email']) != ''){
			$data = array();
			$data[0] = strtoupper($_GET['Nome']);
			$data[1] = ($_GET['Email']);
			$data[2] = ($_GET['Tel']);			
			$data[3] = ($_GET['cuid']);			
			$data[4] = ($_GET['Acesso']);			

			updateClienteUser($conn,$data);		
		}
	}
	//CLIENTE_USER.php --- Processo para Gerar Nova Senha e Enviar Email ao Cliente!
	if(($_GET['sendNewLogin']) == 1){
		if(isset($_GET['Email']) && ($_GET['Email']) != ''){
			$data = array();
			$data[0] = ($_GET['cuid']);
			$data[1] = ($_GET['Email']);
			
			
			updateClienteUserPwd($conn,$data);
		}
	}
	//CLIENTE_USER.php --- Processo para Desabilitar Usuario Convidado
	if(($_GET['removeCuser']) == 1){
		
		removeClienteUser($conn,($_GET['cuid']));
	}

?>