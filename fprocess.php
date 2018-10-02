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
    require("./controller/funcionariosController.php");
    
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

	//'Funcionarios.php --- Processo para Novo Funcionario
	if(($_GET['processMode']) == 0){
		if(isset($_GET['FNome']) && ($_GET['FNome']) != '' && ($_GET['FCpf']) != ''){
			$data = array();
			$data[0] = strtoupper($_GET['FNome']);
			$data[1] = ($_GET['FCpf']);
			$data[2] = ($_GET['FRg']);
			$data[3] = ($_GET['FTel']);
			$data[4] = data_sql(($_GET['eData']));
			$data[5] = ($_GET['FFunc']);

			newFuncionario($conn,$data);
				
		}
	}
	if(($_GET['processMode']) == 1){
		if(isset($_GET['FNome']) && ($_GET['FNome']) != '' && ($_GET['FCpf']) != ''){
			$data = array();
			$data[0] = strtoupper($_GET['FNome']);
			$data[1] = ($_GET['FCpf']);
			$data[2] = ($_GET['FRg']);
			$data[3] = ($_GET['FTel']);
			$data[4] = data_sql(($_GET['eData']));
			$data[5] = ($_GET['FFunc']);
			$data[6] = ($_GET['FId']);
			

			updateFuncionario($conn,$data);
				
		}
	}
?>