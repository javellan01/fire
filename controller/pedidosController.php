<?php

	function data_usql($data) {
		$ndata = substr($data, 8, 2) ."/". substr($data, 5, 2) ."/".substr($data, 0, 4);
		return $ndata;
	}
    
    function moeda($num){
		return number_format($num,2,',','.');
    }

    function getClientes($conn){
        $stmt = $conn->query("SELECT id_cliente,tx_nome,tx_cnpj FROM cliente ORDER BY tx_nome ASC");

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

function getUserClientes($conn,$userid){    
    $stmt = $conn->query("SELECT DISTINCT c.id_cliente,c.tx_nome,c.tx_cnpj 
                        FROM acesso_pedido AS ap
						INNER JOIN pedido AS p ON ap.id_pedido = p.id_pedido
                        INNER JOIN cliente As c ON p.id_cliente = c.id_cliente
						WHERE ap.id_usuario = $userid AND ap.id_cliente_usr IS NULL ORDER BY tx_nome ASC");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

function getPedidosCliente($conn,$cid){
    $stmt = $conn->query("SELECT c.id_cliente, p.tx_codigo, p.id_pedido, p.cs_estado, u.tx_name, v.medido_total, v.nb_valor 
                        FROM cliente As c 
	    				INNER JOIN pedido AS p ON c.id_cliente = p.id_cliente
						INNER JOIN usuario AS u ON p.id_usu_resp = u.id_usuario
						INNER JOIN v_sum_pedido_total AS v ON p.id_pedido = v.id_pedido
						WHERE c.id_cliente = $cid ORDER BY p.tx_codigo ASC;");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    return $data;
  }

function loadPedidosList($conn){

    $stmt = $conn->query("WITH vs AS (SELECT id_pedido, FORMAT(((SUM(progresso) / SUM(nb_valor)) *100),1) as 'execpercent'
    FROM v_categoria_sums
    GROUP BY id_pedido)
    SELECT c.id_cliente, p.tx_codigo, p.id_pedido, DATE_FORMAT(p.dt_idata, '%d/%m/%Y') as 'data', p.cs_estado, u.tx_name,
    IFNULL(v.medido_total,0) as medido_total, v.nb_valor, vs.execpercent, IFNULL(FORMAT(((v.medido_total / v.nb_valor) *100),1),0) as 'percent'
        FROM cliente As c 
        INNER JOIN pedido AS p ON c.id_cliente = p.id_cliente
        INNER JOIN usuario AS u ON p.id_usu_resp = u.id_usuario
        INNER JOIN v_sum_pedido_total AS v ON p.id_pedido = v.id_pedido
        INNER JOIN vs ON p.id_pedido = vs.id_pedido
        ORDER BY p.id_pedido DESC;");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    return $data;

}

function getUserPedidos($conn,$userid){
    
    $stmt = $conn->query("SELECT p.tx_codigo, p.id_pedido, p.cs_estado
                        FROM acesso_pedido AS ap
						INNER JOIN pedido AS p ON ap.id_pedido = p.id_pedido
                        WHERE ap.id_usuario = $userid AND p.cs_estado = 0 ORDER BY p.tx_codigo ASC;");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    return $data;   
    }

function getUserPedidosCliente($conn,$cid,$userid){
    $stmt = $conn->query("SELECT c.id_cliente, p.tx_codigo, p.id_pedido, p.cs_estado, u.tx_name, v.medido_total, v.nb_valor 
                        FROM cliente As c 
                        INNER JOIN pedido AS p ON c.id_cliente = p.id_cliente
                        INNER JOIN usuario AS u ON p.id_usu_resp = u.id_usuario
                        INNER JOIN v_sum_pedido_total AS v ON p.id_pedido = v.id_pedido
                        WHERE c.id_cliente = $cid AND p.id_usu_resp = $userid AND p.cs_estado = 0 ORDER BY p.tx_codigo ASC;");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    return $data;   
    }
    
function getProgressoFisico($conn,$pid){
    $stmt = $conn->query("SELECT vs.id_pedido, FORMAT(((SUM(vs.progresso) / SUM(vs.nb_valor)) *100),1) as execpercent
    FROM v_categoria_sums vs 
    WHERE vs.id_pedido = $pid GROUP BY vs.id_pedido");
    
    $data = $stmt->fetch(PDO::FETCH_OBJ);
    
    return $data;
    }    

function getArquivosPedido($conn,$pid){
    
    $stmt = $conn->query("SELECT * 
                        FROM arq_tecnico
                        WHERE id_pedido = $pid");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    return $data;   

}    

function insertArquivoTecnico($conn,$data){
    $e = null;
    try{
        
        $stmt = $conn->prepare("REPLACE INTO arq_tecnico (id_pedido, tx_documento, tx_arquivo, dt_upload, tx_version, nb_tamanho)
                                VALUES (:id_pedido, :tx_documento, :tx_arquivo,  :dt_upload, :tx_version, :nb_tamanho)");

        $stmt->bindParam(':dt_upload',$data['dataUpload']);
        $stmt->bindParam(':tx_documento',$data['tx_documento']);
        $stmt->bindParam(':id_pedido',$data['Pid']);
        $stmt->bindParam(':tx_version',$data['tx_version']);
        $stmt->bindParam(':tx_arquivo',$data['tx_arquivo']);
        $stmt->bindParam(':nb_tamanho',$data['nb_tamanho']);
       
        $stmt->execute();
        }
    catch(PDOException $e)
				{
				print_r($e);
				}
			
}

function getPedidoData($conn, $pid){

    $stmt = $conn->query("SELECT p.*, c.tx_nome 
    FROM pedido p 
    INNER JOIN cliente c ON p.id_cliente = c.id_cliente 
    WHERE p.id_pedido = $pid");

    $data = $stmt->fetch(PDO::FETCH_OBJ);
	
    return $data;

}

function excludeArquivoPedido($conn, $data){

    $e = null;

    try{
    $stmt = $conn->prepare("DELETE FROM arq_tecnico
                         WHERE id_pedido = :id_pedido AND tx_arquivo = :tx_arquivo");
    $stmt->bindParam(':id_pedido',$data['id_pedido']);                         
    $stmt->bindParam(':tx_arquivo',$data['tx_arquivo']);                         

    $stmt->execute();
    }
    catch(PDOException $e){
        echo $e->getMessage();
        }
        if($e == null) echo "Arquivo ".$data['tx_arquivo']." Excluído!";

}
?>