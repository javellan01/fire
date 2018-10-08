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
    require("./controller/atividadesController.php");
    
	
	function data_sql($data) {
		$ndata = substr($data, 6, 4) ."-". substr($data, 3, 2) ."-".substr($data, 0, 2);
		return $ndata;
    }

	//CLIENTE_USER.php --- Processo para NOVO Usuario Convidado
	if(($_GET['removePedido']) == 1){
		if(isset($_GET['Pid'])){
            $data = $_GET['Pid'];
            
            removePedido($conn,$data);
           
		}
	}

    if(($_GET['updatePedido']) == 1){
		if(isset($_GET['pid']) && ($_GET['Codigo']) != ''){
			$data = array();
			$data[0] = $_GET['Codigo'];
			$data[1] = $_GET['Local'];
			$data[2] = $_GET['pdDescricao'];
			$data[3] = $_GET['Valor'];
			$data[4] = $_GET['Retencao'];
			$data[5] = $_GET['Status'];
			$data[6] = data_sql($_GET['idata']);
			$data[7] = data_sql($_GET['tdata']);
			$data[8] = $_GET['User'];
			$data[9] = $_GET['Cuser'];
            $data[10] = $_GET['pid'];
            
            updatePedido($conn,$data);
           
		}
	}
	
?>