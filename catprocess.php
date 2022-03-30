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

	require("./controller/agentController.php");
	Auth::accessControl($_SESSION['catuser'],0);
	require("./DB/conn.php");
    require("./controller/configController.php");
    
	
	
// UPDATE DA Categoria
	if(($_POST['updateCategoria']) == 1){
		if(($_POST['id_categoria']) != '' && ($_POST['tx_nome']) != '' && ($_POST['tx_color']) != ''){
			$data = array();
			$data[0] = $_POST['id_categoria']; 
			$data[1] = $_POST['tx_nome'];	
			$data[2] = $_POST['tx_color'];  

            updateCategoria($conn,$data);
           
		}
	}
// NOVA CATEGORIA
	if(($_POST['novaCategoria']) == 1){
		if(($_POST['id_categoria']) != '' && ($_POST['tx_nome']) != '' && ($_POST['tx_color']) != ''){
			$data = array();
			$data[0] = $_POST['id_categoria']; 
			$data[1] = $_POST['tx_nome'];	
			$data[2] = $_POST['tx_color'];  

            novaCategoria($conn,$data);
           
		}
	}

//Remove Categoria
	if(($_POST['removeCategoria']) == 1){
		if(($_POST['id_categoria']) != ''){
			$data = $_POST['id_categoria'];		//id_atividade

            removeCategoria($conn,$data);
           
		}
	}

	
?>