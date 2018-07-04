<?php
	session_start();
	if(!isset($_SESSION["login"]) && !isset($_SESSION["usuario"]) && !isset($_SESSION["userid"])) 
		{ 
	// Usuário não logado! Redireciona para a página de login 
		header("Location: login.php"); 
		exit; 
	} 

	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: 0");
	
	require("./DB/conn.php");
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
	
	//'Pedidos.php' ---	Processa para criar nova medição
	
	if(isset($_GET['idAtiv']) && isset($_GET['idPedido']) && isset($_GET['nbOrdem'])){
		
	$id_pedido = $nb_ordem = $dt_idata = "";
	$loop = 0;
	$id_pedido = $_GET['idPedido'];
	$nb_ordem = $_GET['nbOrdem'];
	$dt_data = data_sql($_GET['MData']);
	
				
	foreach($_GET['idAtiv'] as $id_atividade){
			
			$nb_valor = $_GET['nbVal'][$id_atividade];
			if($nb_valor == 0) continue;
			
			try{
			$stmt2 = $conn->prepare("INSERT INTO atividade_medida (id_atividade, nb_valor, nb_ordem, id_pedido) VALUES (:id_atividade, :nb_valor, :nb_ordem, :id_pedido)");
	
			$stmt2->bindParam(':id_pedido', $id_pedido);
			$stmt2->bindParam(':nb_ordem', $nb_ordem);
			$stmt2->bindParam(':id_atividade', $id_atividade);
			$stmt2->bindParam(':nb_valor', $nb_valor);	
			$stmt2->execute();
			$loop += 1;
			}
			catch(PDOException $e)
				{
				echo "Error Atividade Proc.: " . $e->getMessage();
				}
		}
		if($loop != 0){
			
		try{	
		$stmt = $conn->prepare("INSERT INTO medicao (id_pedido, nb_ordem, dt_data, id_usuario) VALUES (:id_pedido, :nb_ordem, :dt_data, :id_usuario)");
	
		$stmt->bindParam(':dt_data', $dt_data);
		$stmt->bindParam(':id_pedido', $id_pedido);
		$stmt->bindParam(':nb_ordem', $nb_ordem);
		$stmt->bindParam(':id_usuario', $_SESSION['userid']);
		$stmt->execute();
		}
		catch(PDOException $e)
			{
			echo "Error Pedido Proc.: " . $e->getMessage();
			}
			
			if($e == null) echo "Medicao: ".$nb_ordem." cadastrada!";
		}
	
	}
	
?>