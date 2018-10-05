<?php
session_start();

$_SESSION['MAtiv'] = array();

function data_usql($data) {
    $ndata = substr($data, 8, 2) ."/". substr($data, 5, 2) ."/".substr($data, 0, 4);
    return $ndata;
}

function time_usql($data) {
    $ndata = substr($data, 8, 2) ."/". substr($data, 5, 2) ."/".substr($data, 0, 4).substr($data, 10, 9);
    return $ndata;
}

function moeda($num){
    return number_format($num,2,',','.');
}


function getPedidoData($conn, $pid){
    $stmt = $conn->query("SELECT p.*, (( p.nb_valor / 100) * p.nb_retencao) AS retencao, c.tx_nome FROM pedido p INNER JOIN cliente c ON p.id_cliente = c.id_cliente WHERE p.id_pedido = $pid");

    $data = $stmt->fetch(PDO::FETCH_OBJ);
	
    return $data;

}

function getMedicoes($conn, $pid){
    $stmt = $conn->query("SELECT SUM(am.nb_valor) AS v_medido, m.id_usuario, m.*, u.tx_name  FROM atividade_medida am 
			LEFT JOIN medicao m ON am.id_pedido=m.id_pedido AND am.nb_ordem = m.nb_ordem 
			INNER JOIN usuario u ON m.id_usuario = u.id_usuario 
            WHERE m.id_pedido = $pid GROUP BY m.nb_ordem ASC");
            
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;

}

function getMedicaoResume($conn,$pid,$mid){
    $stmt = $conn->query("SELECT a.id_categoria, a.tx_descricao, cat.tx_nome, am.nb_valor AS nb_valor, ((am.nb_valor/a.nb_valor)*100) AS percent FROM atividade_medida AS am INNER JOIN atividade AS a ON am.id_atividade = a.id_atividade INNER JOIN categoria AS cat ON a.id_categoria = cat.id_categoria WHERE am.id_pedido = ".$pid." AND am.nb_ordem = ".$mid." ORDER BY a.id_categoria ASC;");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

function getCategoria($conn,$pid){
    $stmt = $conn->query("SELECT c.* FROM atividade a  
        INNER JOIN categoria c ON a.id_categoria=c.id_categoria	WHERE a.id_pedido = $pid GROUP BY a.id_categoria ASC");
        
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

function getCategoriaSum($conn,$pid,$cid){
    $stmt = $conn->query("SELECT FORMAT(((progresso / nbvalor) *100),1) as execpercent, FORMAT(((valorsum / nbvalor) *100),1) as medpercent, id_categoria, nbvalor, valorsum, qtdsum, nbqtd, progresso, v_unit FROM (SELECT id_categoria, SUM(nb_valor) nbvalor, SUM(valor_sum) valorsum, SUM(qtd_sum) qtdsum, SUM(nb_qtd) nbqtd, SUM(progresso) progresso, v_unit FROM v_categoria_sums WHERE id_pedido = $pid AND id_categoria = $cid GROUP BY id_categoria) AS tb");

    $data = $stmt->fetch(PDO::FETCH_OBJ);

    return $data;
}

function getAtividades($conn,$pid,$cid){
    $stmt = $conn->query("SELECT b.*, FORMAT(((b.qtd_sum/b.nb_qtd)*100),1) AS percent, FORMAT(((b.valor_sum/b.nb_valor)*100),1) AS medpercent, FORMAT(((b.progresso/b.nb_valor)*100),1) AS execpercent FROM (SELECT a.*, v1.qtd_sum, v1.progresso, v1.valor_sum FROM atividade a LEFT JOIN v_categoria_sums v1 ON a.id_atividade=v1.id_atividade WHERE a.id_pedido = $pid AND a.id_categoria = $cid) AS b");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}