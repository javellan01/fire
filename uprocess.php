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
	//'Perfil.php --- Processo para alterar senha
	if(isset($_GET['ASenha']) && ($_GET['ASenha']) != ''){
		$tx_password = md5($_GET['ASenha']);
		$id_usuario = $_SESSION["userid"];
			try{
		$stmt = $conn->prepare("UPDATE usuario SET tx_password = :tx_password WHERE id_usuario = :id_usuario");
		$stmt->bindParam(':tx_password', $tx_password);
		$stmt->bindParam(':id_usuario', $id_usuario);
		$stmt->execute();
				}
			catch(PDOException $e)
				{
				echo "Error Altera Senha Proc.: " . $e->getMessage();
				}
				
				if($e == null) echo "Senha alterada com sucesso!";
	}
	
	//'Perfil.php --- Processo para alterar usuario
	if(isset($_GET['EdUsuario']) && ($_GET['EdUsuario']) != ''){
		
	$tx_name = $tx_telefone = $tx_email = "";
	
	$tx_name = strtoupper($_GET['EdUsuario']);
	if(isset($_GET['Telefone'])){   	 $tx_telefone = $_GET['Telefone'];}
	if(isset($_GET['Email'])){   	 $tx_email = $_GET['Email'];}
	$id_usuario = $_SESSION["userid"];
	
		try{
	$stmt = $conn->prepare("UPDATE usuario SET tx_name = :tx_name, tx_telefone = :tx_telefone, tx_email = :tx_email WHERE id_usuario = :id_usuario");
	
	$stmt->bindParam(':tx_name', $tx_name);
	$stmt->bindParam(':tx_telefone', $tx_telefone);
	$stmt->bindParam(':tx_email', $tx_email);
	$stmt->bindParam(':id_usuario', $id_usuario);
	
	$stmt->execute();
		}
	catch(PDOException $e)
		{
		echo "Error User Edit Proc.: " . $e->getMessage();
		}
		$_SESSION['usuario'] = $tx_name;
		if($e == null) echo "Usuário: ".$tx_name." editado com sucesso!";
	}
	
	
	//'Usuarios.php' ---	Processa para Editar Usuario ADMIN Mode
	if(isset($_GET['edit.Userid']) && isset($_GET['edit.Usuario']) && ($_GET['edit.Usuario']) != '' && ($_GET['edit.CPF']) != ''){
		
	$tx_name = $tx_cpf = $tx_telefone = $nb_category_user = $tx_email = $id_usuario = "";
	$id_usuario = (int)$_GET['edit.Userid'];
	$tx_name = strtoupper($_GET['Usuario']);
	$tx_cpf = $_GET['edit.CPF'];
	
	if(isset($_GET['edit.Telefone'])){   	 $tx_telefone = $_GET['edit.Telefone'];}
	if(isset($_GET['edit.Catuser'])){   	 $nb_category_user = $_GET['edit.Catuser'];}
	if(isset($_GET['edit.Email'])){   		 $tx_email = $_GET['edit.Email'];}
	
	
		try{
	$stmt = $conn->prepare("UPDATE usuario 
						SET tx_name = :tx_name, tx_cpf = :tx_cpf, tx_telefone = :tx_telefone, nb_category_user = :nb_category_user, tx_email = :tx_email
						WHERE id_usuario = :id_usuario");
	
	$stmt->bindParam(':id_usuario', $id_usuario);
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
		
		if($e == null) echo "Usuário: ".$tx_name." atualizado!";
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
	$id_usu_resp = $_GET['Responsavel'];
	$nb_retencao = $_GET['Retencao'];
	$id_cliente = $_GET['idCliente']; 
	$dt_idata = data_sql($dt_idata);	
	$dt_tdata = data_sql($dt_tdata);
	
		try{
	$stmt = $conn->prepare("INSERT INTO pedido (tx_codigo, tx_descricao, tx_local, dt_idata, dt_tdata, id_cliente, nb_retencao, nb_valor, id_usu_resp) VALUES (:tx_codigo, :tx_descricao, :tx_local, :dt_idata, :dt_tdata, :id_cliente, :nb_retencao, :nb_valor, :id_usu_resp)");
	$stmt->bindParam(':tx_codigo', $tx_codigo);
	$stmt->bindParam(':tx_descricao', $tx_descricao);
	$stmt->bindParam(':tx_local', $tx_local);
	$stmt->bindParam(':dt_idata', $dt_idata);
	$stmt->bindParam(':dt_tdata', $dt_tdata);
	$stmt->bindParam(':id_cliente', $id_cliente);
	$stmt->bindParam(':nb_valor', $nb_valor);
	$stmt->bindParam(':nb_retencao', $nb_retencao);
	$stmt->bindParam(':id_usu_resp', $id_usu_resp);
	
	$stmt->execute();
		}
	catch(PDOException $e)
		{
		echo "Error Pedido Proc.: " . $e->getMessage();
		}
		
		if($e == null) echo "Pedido: ".strtoupper($tx_codigo).", R$ ".$nb_valor." - Início:".$dt_idata.", cadastrado!";
	}
	
	
	
?>