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
                        FROM cliente AS c 
						INNER JOIN pedido AS p ON c.id_cliente = p.id_cliente
						WHERE p.id_usu_resp = $userid ORDER BY tx_nome ASC");

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
    $stmt = $conn->query("SELECT vs.id_pedido, FORMAT(((SUM(vs.progresso) / tb.total) *100),1) as execpercent
    FROM v_categoria_sums vs 
    INNER JOIN (SELECT id_pedido, ((nb_valor / 100) * (100 - nb_retencao)) as total FROM pedido) AS tb ON vs.id_pedido = tb.id_pedido
    WHERE vs.id_pedido = $pid GROUP BY vs.id_pedido");
    
    $data = $stmt->fetch(PDO::FETCH_OBJ);
    
    return $data;
    }    
    
    
?>