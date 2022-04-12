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

	$data = '';

	$data = $_POST['id_pedido'];

    getGraphProgressoPedido($conn,$data);


?>