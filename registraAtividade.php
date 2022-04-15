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

	$data['userid'] = $_SESSION['userid'];
	$data['id_atividade'] = $_POST['id_atividade'];
    $data['nb_qtd'] = (int)$_POST['nb_qtd'];
    $data['dt_date'] = data_sql($_POST['dt_date']);
    $data['finalizar'] = 0;
    
	$max = verificaQtd($conn,$data['id_atividade']);
	if($data['nb_qtd'] >= $max){
		$data['nb_qtd'] = $max;
        $data['finalizar'] = 1;
	}

    if(verifyAtividadeExec($conn,$data)) registraAtividadeExec($conn,$data);

    }
}
?>