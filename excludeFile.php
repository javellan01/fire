<?php
session_start();

if(!isset($_SESSION["login"]) && !isset($_SESSION["usuario"]) && !isset($_SESSION["userid"]) ) 
		{ 
		// Usuário não logado! Redireciona para a página de login 
		header('HTTP/1.1 403 Forbidden'); 
		exit; 
	}

require("./controller/agentController.php");
Auth::accessControl($_SESSION['catuser'],0);

require("./DB/conn.php");
require("./controller/pedidosController.php");

	$data = array();
	$data['id_pedido'] = $_POST['data'];
	$data['tx_arquivo'] = $_POST['fname'];
	$id = md5($_POST['data']);
	$fname = $_POST['fname'];
	$type = $_POST['type'];

if($type == 'tecnico'){
	// path to the file
	$path = './storage/'.$type.'/'.$id;
	// file path
	$file = $path.'/'.$fname.'';
	if(is_dir($path)){
	
		if(is_file($file)){
		
		unlink($file);
		excludeArquivoPedido($conn,$data);
		exit;
		}
		else{
			excludeArquivoPedido($conn,$data);
			exit;
		}
	}
	else{
		excludeArquivoPedido($conn,$data);
		exit;
	}
}

?>