<?php
	 session_start();
	 if(!isset($_SESSION["login"]) || !isset($_SESSION["usuario"]) || !isset($_SESSION["userid"])) 
		 { 
	 // Usuário não logado! Redireciona para a página de login 
		 header("Location: login.php"); 
		 exit; 
	 } 

	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: 0");

	require("./DB/conn.php");
    require("./controller/atividadesController.php");
    
	
	function data_sql($data) {
		$ndata = substr($data, 6, 4) ."-". substr($data, 3, 2) ."-".substr($data, 0, 2);
		return $ndata;
    }

	//detpedido.php REMOVER PEDIDO apenas fica inacessivel para o sistema, mas não é removido do banco
	if(($_GET['removePedido']) == 1){
		if(isset($_GET['Pid'])){
            $data = $_GET['Pid'];
            
            removePedido($conn,$data);
           
		}
	}
 //detpedido.php ATUALIZAR PEDIDO get value from modalButton

    if(($_GET['updatePedido']) == 1){
		if(isset($_GET['pid']) && ($_GET['Codigo']) != ''){
			$data = array();
			$data[0] = $_GET['Codigo'];
			$data[1] = $_GET['Local'];
			$data[2] = $_GET['pdDescricao'];
			$data[3] = $_GET['Valor'];
			$data[4] = $_GET['Retencao'];
			$data[5] = $_GET['Status'];
			$data[6] = data_sql($_GET['idata']);
			$data[7] = data_sql($_GET['tdata']);
			$data[8] = $_GET['User'];
			$data[9] = $_GET['Cuser'];
            $data[10] = $_GET['pid'];
            
            updatePedido($conn,$data);
           
		}
	}
// UPDATE DA Atividade listada
	if(($_GET['updateAtividade']) == 1){
		if(($_GET['Atividade']) != ''){
			$data = array();
			$data[0] = $_GET['Descricao']; //tx_descricao
			$data[1] = $_GET['Tipo'];	//tx_tipo
			$data[2] = $_GET['Qtd'];  //nb_qtd
			$data[3] = $_GET['Valor'];  //nb_valor
			$data[4] = data_sql($_GET['Inicio']);  //dt_inicio
			$data[5] = data_sql($_GET['Fim']);  //dt_fim
			$data[6] = $_GET['Atividade'];		//id_atividade

            updateAtividade($conn,$data);
           
		}
	}
//EXCLUI ATIVIDADE listada	
	if(($_GET['excluirAtividade']) == 1){
		if(($_GET['Atividade']) != ''){
			$data = $_GET['Atividade'];		//id_atividade

            excluirAtividade($conn,$data);
           
		}
	}

	if(($_GET['alocaFuncionario']) == 1){
		if(($_GET['Fid']) != '' && ($_GET['Pid']) != ''){
			$data = array();
			$data[0] = $_GET['Fid'];    //FUNCIONARIO ID
			$data[1] = $_GET['Pid'];	//PEDIDO ID
			
            alocaFuncionario($conn,$data);
           
		}
	}

	if(($_GET['removeFuncionario']) == 1){
		if(($_GET['Fid']) != '' && ($_GET['Pid']) != ''){
			$data = array();
			$data[0] = $_GET['Fid'];    //FUNCIONARIO ID
			$data[1] = $_GET['Pid'];	//PEDIDO ID

            removeFuncionario($conn,$data);
           
		}
	}
?>