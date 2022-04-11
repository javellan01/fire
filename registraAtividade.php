<?php
 session_start();
 if(!isset($_SESSION["login"]) || !isset($_SESSION["usuario"]) || !isset($_SESSION["userid"])) 
     { 
 // Usuário não logado! Redireciona para a página de login 
     header("Location: login.php"); 
     exit; 
 } 

require("./DB/conn.php");
require("./controller/atividadesController.php");

function data_sql($data) {
    $ndata = substr($data, 6, 4) ."-". substr($data, 3, 2) ."-".substr($data, 0, 2);
    return $ndata;
}
if($_POST['registraAtividade'] == 1){
if(($_POST['id_atividade']) && ($_POST['nb_qtd']) != '' && ($_POST['id_atividade']) != 0){
	
	$data = array();

	$data[0] = $_SESSION['userid'];
	$data[1] = $_POST['id_atividade'];
    $data[2] = (int)$_POST['nb_qtd'];
    $data[3] = data_sql($_POST['dt_date']);
	
	$max = verificaQtd($conn,$data[1]);
	if($data[2] > $max){
		$data[2] = $max;
	}

    if(verifyAtividadeExec($conn,$data)) registraAtividadeExec($conn,$data);

    }
}
?>