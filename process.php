<?php
	require('conn.php');
	$e = null;
	$stmt = null;
	
	
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	if(isset($_GET['Atividade']) && ($_GET['Atividade']) != ''){
	$tx_nome = $cid = $categoria = $nb_qtd = $nb_valor = $tx_tipo = $pid = "";
	strtoupper($tx_nome = $_GET['Atividade']);
	$tx_nome .= " ".$_GET['Tubo'];
	if(isset($_GET['Categoria'])){   $categoria = $_GET['Categoria'];}
	if(isset($_GET['Qtd'])){   		 $nb_qtd = (int)$_GET['Qtd'];}
	if(isset($_GET['Valor'])){  	 $nb_valor = (float)$_GET['Valor'];}
	if(isset($_GET['Tipo'])){  		 strtoupper($tx_tipo  = $_GET['Tipo']);}
	if(isset($_GET['Pid'])){   		 $pid = (int)$_GET['Pid'];}
	$cid = (int)substr($categoria,0,1);
	
		try{
	$stmt = $conn->prepare("INSERT INTO atividade (tx_descricao, id_categoria, nb_qtd, nb_valor, tx_tipo, id_pedido)
    VALUES (:tx_descricao, :id_categoria, :nb_qtd, :nb_valor, :tx_tipo, :id_pedido)");
	$stmt->bindParam(':tx_descricao', $tx_nome);
	$stmt->bindParam(':tx_tipo', $tx_tipo);
	$stmt->bindParam(':id_categoria', $cid);
	$stmt->bindParam(':nb_qtd', $nb_qtd);
	$stmt->bindParam(':nb_valor', $nb_valor);
	$stmt->bindParam(':id_pedido', $pid);
	$stmt->execute();
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
		
		if($e == null) echo strtoupper($tx_nome)." ".$nb_qtd." ".strtoupper($tx_tipo).", Valor: R$ ".$nb_valor." - Atividade Cadastrada!";
	}
	
	if(isset($_GET['Cliente']) && ($_GET['Cliente']) != ''){
		
	$tx_nome = $cnpj = "";
	
	strtoupper($tx_nome =$_GET['Cliente']);
	if(isset($_GET['CNPJ'])){   	 $cnpj = $_GET['CNPJ'];}
	if(isset($_GET['pdDescricao'])){   	 $tx_descricao = $_GET['pdDescricao'];}
	
		try{
	$stmt = $conn->prepare("INSERT INTO cliente (tx_nome, tx_cnpj, tx_descricao) VALUES (:tx_nome, :tx_cnpj,:tx_descricao)");
	$stmt->bindParam(':tx_nome', $tx_nome);
	$stmt->bindParam(':tx_cnpj', $cnpj);
	$stmt->bindParam(':tx_descricao', $tx_descricao);

	$stmt->execute();
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
		
		if($e == null) echo "Cliente: ".strtoupper($tx_nome)." - ".$cnpj.", cadastrado!";
	}
	
?>