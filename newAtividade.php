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

if(($_POST['generateButton']) && $_POST['generateButton'] == 1){
    if(($_POST['id_categoria']) && ($_POST['id_pedido'])  && ($_POST['nb_loops']) != 0){
	
	$data = array();

	$data[0] = $_POST['id_pedido'];
	$data[1] = $_POST['id_categoria'];
    $number = (int)$_POST['nb_loops'];
    
    if($data[1] == 0) {
        $e = "Erro! Selecionar categoria para gerar as atividades.";
        return $e;
    }
    
	$max = 50;
	if($number > $max){
		$number = $max;
	}

    createMultipleAtividades($conn,$number,$data);

    }
}

?>