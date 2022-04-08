<?php
 session_start();
 if(!isset($_SESSION["login"]) || !isset($_SESSION["usuario"]) || !isset($_SESSION["userid"])) 
     { 
 // Usuário não logado! Redireciona para a página de login 
     header("Location: login.php"); 
     exit; 
 } 

require("/DB/conn.php");
require("/controller/mailController.php");


if(isset($_POST['contato']) && ($_POST['sendNotificacao']) == 1){
    if(isset($_POST['id_medicao']) && ($_POST['id_medicao']) != '' && ($_POST['contatos']) != 0){

    $data = $_POST['contato'];    
	$medicao = $_POST['id_medicao'];

    sendMedicao($data,$medicao);

    }
}
?>