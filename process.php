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
	
	//'Atividade.php' ---	Processa para inserir nova atividade no database
	if(isset($_GET['Atividade']) && ($_GET['Atividade']) != ''){
	$tx_nome = $cid = $categoria = $nb_qtd = $nb_valor = $tx_tipo = $pid = "";
	$tx_nome = strtoupper($_GET['Atividade']);
	$tx_nome .= " ".$_GET['Tubo'];

	if(isset($_GET['Qtd'])){   		 $nb_qtd = (int)$_GET['Qtd'];}
	if(isset($_GET['Valor'])){  	 $nb_valor = (float)$_GET['Valor'];}
	if(isset($_GET['Tipo'])){  		 strtoupper($tx_tipo  = $_GET['Tipo']);}
	if(isset($_GET['Pid'])){   		 $pid = (int)$_GET['Pid'];}
	$cid = $_GET['Categoria'];
	
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
		echo "Error Ativ. Proc.: " . $e->getMessage();
		}
		
		if($e == null) echo strtoupper($tx_nome)." ".$nb_qtd." ".strtoupper($tx_tipo).", Valor: R$ ".$nb_valor." - Atividade Cadastrada!";
	}
	
	//'Pedidos.php' ---	Processa para inserir novo CLIENTE no database
	if(isset($_GET['Cliente']) && ($_GET['Cliente']) != ''){
		
	$tx_nome = $cnpj = "";
	
	$tx_nome = strtoupper( $_GET['Cliente']);
	if(isset($_GET['CNPJ'])){   	 $cnpj = $_GET['CNPJ'];}
	
		try{
	$stmt = $conn->prepare("INSERT INTO cliente (tx_nome, tx_cnpj) VALUES (:tx_nome, :tx_cnpj)");
	$stmt->bindParam(':tx_nome', $tx_nome);
	$stmt->bindParam(':tx_cnpj', $cnpj);

	$stmt->execute();
		}
	catch(PDOException $e)
		{
		echo "Error Cliente Proc.: " . $e->getMessage();
		}
		
		if($e == null) echo "Cliente: ".strtoupper($tx_nome)." - ".$cnpj.", cadastrado!";
	}
	
	
	//'Usuarios.php' ---	Processa para inserir novo USUARIO no database
	if(isset($_GET['Usuario']) && ($_GET['Usuario']) != ''){
		
	$tx_name = $tx_cpf = $tx_telefone = $nb_category_user = $tx_email = "";
	
	$tx_name = strtoupper($_GET['Usuario']);
	if(isset($_GET['CPF'])){   	 		 $tx_cpf = $_GET['CPF'];}
	if(isset($_GET['Telefone'])){   	 $tx_telefone = $_GET['Telefone'];}
	if(isset($_GET['Catuser'])){   	 $nb_category_user = $_GET['Catuser'];}
	if(isset($_GET['Email'])){   	 $tx_email = $_GET['Email'];}
		
		try{
	$stmt = $conn->prepare("INSERT INTO usuario (tx_name, tx_cpf, tx_telefone, nb_category_user, tx_email) VALUES (:tx_name, :tx_cpf, :tx_telefone, :nb_category_user, :tx_email)");
	
	$stmt->bindParam(':tx_name', $tx_name);
	$stmt->bindParam(':tx_cpf', $tx_cpf);
	$stmt->bindParam(':tx_telefone', $tx_telefone);
	$stmt->bindParam(':nb_category_user', $nb_category_user);
	$stmt->bindParam(':tx_email', $tx_email);
	
	$stmt->execute();
		}
	catch(PDOException $e)
		{
		echo "Error User Proc.: " . $e->getMessage();
		}
		
		if($e == null) echo "Usuário: ".$tx_name." cadastrado!";
	}
	
	//'Pedidos.php' ---	Processa para inserir novo PEDIDO no database
	
	if(isset($_GET['Pedido']) && ($_GET['Pedido']) != ''){
		
	$tx_codigo = $tx_descricao = $id_cliente = $dt_idata = $dt_tdata = $nb_retencao = $nb_valor = "";
	
	$tx_codigo = strtoupper($_GET['Pedido']);
	if(isset($_GET['iData'])){   	 $dt_idata = $_GET['iData'];}
	if(isset($_GET['tData'])){   	 $dt_tdata = $_GET['tData'];}
	if(isset($_GET['pdDescricao'])){   	 $tx_descricao = $_GET['pdDescricao'];}
	if(isset($_GET['valorPedido'])){   	 $nb_valor = $_GET['valorPedido'];}
	if(isset($_GET['Local'])){   	 $tx_local = strtoupper($_GET['Local']);}
	$nb_retencao = $_GET['Retencao'];
	$id_cliente = $_GET['idCliente']; 
		
		try{
	$stmt = $conn->prepare("INSERT INTO pedido (tx_codigo, tx_descricao, tx_local, dt_idata, dt_tdata, id_cliente, nb_retencao, nb_valor) VALUES (:tx_codigo, :tx_descricao, :tx_local, :dt_idata, :dt_tdata, :id_cliente, :nb_retencao, :nb_valor)");
	$stmt->bindParam(':tx_codigo', $tx_codigo);
	$stmt->bindParam(':tx_descricao', $tx_descricao);
	$stmt->bindParam(':tx_local', $tx_local);
	$stmt->bindParam(':dt_idata', $dt_idata);
	$stmt->bindParam(':dt_tdata', $dt_tdata);
	$stmt->bindParam(':id_cliente', $id_cliente);
	$stmt->bindParam(':nb_valor', $nb_valor);
	$stmt->bindParam(':nb_retencao', $nb_retencao);
	
	$stmt->execute();
		}
	catch(PDOException $e)
		{
		echo "Error Pedido Proc.: " . $e->getMessage();
		}
		
		if($e == null) echo "Pedido: ".strtoupper($tx_codigo).", R$ ".$nb_valor." - Início:".$dt_idata.", cadastrado!";
	}
	
	
	
?>