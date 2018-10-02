<?php
session_start();

$token = md5(session_id());
if(!isset($_SESSION["login"]) || !isset($_GET['token']) ) 
		{ 
	// Usuário não logado! Redireciona para a página de login 
		header("Location: login.php"); 
		exit; 
	} 
	
	$id = $_GET['data'];
	$fname = $_GET['fname'];
	
	header('Location: ./storage/funcionarios/'.$id.'/'.$fname.'');

?>