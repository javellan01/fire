<?php
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

function calcularPercent($parcel,$total,$precision){
    
    $result = ($parcel/$total)*100;
    
    return number_format($result,$precision,',','.');
}

function verificaQtd($conn,$id_atividade){

    $stmt = $conn->query("SELECT * FROM v_sum_atividade_exec WHERE id_atividade = $id_atividade");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    $result = $data[0]->nb_qtd - $data[0]->qtd_sum;
    
    return $result;
}

function getUsrPedidoData($conn, $pid){

    $stmt = $conn->query("SELECT p.*, c.tx_nome 
    FROM pedido p 
    INNER JOIN cliente c ON p.id_cliente = c.id_cliente 
    WHERE p.id_pedido = $pid");

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

    $stmt = $conn->query("SELECT a.id_categoria, a.id_atividade, a.tx_descricao, a.id_idx AS item, cat.tx_nome, a.nb_valor AS nb_sum, am.nb_valor AS nb_valor, ((am.nb_valor/a.nb_valor)*100) AS percent 
    FROM atividade_medida AS am 
    INNER JOIN atividade AS a ON am.id_atividade = a.id_atividade 
    INNER JOIN categoria AS cat ON a.id_categoria = cat.id_categoria
    WHERE am.id_pedido = ".$pid." AND am.nb_ordem = ".$mid." ORDER BY a.id_categoria ASC;");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

function getStatus($conn,$mid){

    $stmt = $conn->query("SELECT md.id_cliente_usr, md.cs_aprovada, md.cs_revisar, md.cs_finalizada, md.dt_aprovacao, cu.tx_nome FROM medicao AS md
                            INNER JOIN cliente_usr AS cu ON md.id_cliente_usr = cu.id_usuario
                            WHERE md.id_medicao = $mid");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    if(count($data) == 0){
        $e = '<span class="text-warning">Aguardando Aprovação.</span>';
        return $e;    
    }else{
        if($data[0]->cs_aprovada == 1 && $data[0]->cs_finalizada == 0){
            $e = '<span class="text-success">Aprovada por '.$data[0]->tx_nome.' em '.data_usql($data[0]->dt_aprovacao).'.</span>';
            return $e;
        }
        
        if($data[0]->cs_revisar == 1 && $data[0]->cs_finalizada == 0){
            $e = '<span class="text-warning">Revisão Solicitada por '.$data[0]->tx_nome.'.</span>';
            return $e;
        }
        if($data[0]->cs_finalizada == 1){
            $e = '<span class="text-success">Medição Finalizada.</span>';
            return $e;
        }

            $e = '<span class="text-warning">Aguardando Aprovação.</span>';
            return $e;
        
    }                           
}

function getMessage($conn, $mid){

    $stmt = $conn->query("SELECT * FROM comentario_medicao WHERE id_medicao = $mid");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    if($data){
        $e = '
        <h5 class="card-title">Comentário:</h5>
        <p class="card-text text-primary">'.$data[0]->tx_comentario.'</p>';
        return $e;
    } 

    
}

function getListaCategorias($conn){
    $stmt = $conn->query("SELECT * FROM categoria c  
                        GROUP BY id_categoria ASC");
        
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

function getCategoriaAtividades($conn,$pid,$mid){

    $stmt = $conn->query("SELECT DISTINCT a.id_categoria, cat.tx_nome
                    FROM atividade_medida AS am 
                    INNER JOIN atividade AS a ON am.id_atividade = a.id_atividade 
                    INNER JOIN categoria AS cat ON a.id_categoria = cat.id_categoria
                    WHERE am.id_pedido = ".$pid." AND am.nb_ordem = ".$mid." ORDER BY a.id_categoria ASC;");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
};

function getUsrCategoriaPedido($conn,$pid){

    $stmt = $conn->query("SELECT c.*, (a.nb_valor / a.nb_qtd) v_unit FROM atividade a  
                    INNER JOIN categoria c ON a.id_categoria=c.id_categoria
                    WHERE a.id_pedido = $pid GROUP BY a.id_categoria ASC");
        
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

function getUsrAtividades($conn,$pid,$cid){

    $stmt = $conn->query("SELECT a.*, v1.qtd_sum, v1.progresso, v1.nb_valor, v1.valor_sum 
                    FROM atividade a 
                    LEFT JOIN v_categoria_sums v1 ON a.id_atividade=v1.id_atividade 
                    WHERE a.id_pedido = $pid AND a.id_categoria = $cid AND a.cs_finalizada = 0 AND NOT a.dt_inicio = '00-00-0000' ");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

function getGraphProgressoPedido($conn,$pid){

    $stmt = $conn->query("SELECT COUNT(*) AS total,
    COUNT(CASE WHEN done = 1 THEN 1 END) AS pronto,
    COUNT(CASE WHEN done < 1 AND done > 0.75 THEN 1 END) AS quasepronto,
    COUNT(CASE WHEN done <= 0.75 AND done > 0.50 THEN 1 END) AS meiocheio,
    COUNT(CASE WHEN done <= 0.50 AND done > 0.25 THEN 1 END) AS meiovazio,
    COUNT(CASE WHEN done <= 0.25 AND done > 0 THEN 1 END) AS umquarto,
    COUNT(CASE WHEN done = 0 THEN 1 END) AS semprogresso
    FROM (SELECT qtd_sum /nb_qtd AS done FROM v_categoria_sums WHERE id_pedido = $pid) AS tabela001");

    $data = $stmt->fetch(PDO::FETCH_OBJ);

    $output = array();
    
    $output[0]=$data->total;
    $output[1]=$data->pronto;
    $output[2]=$data->quasepronto;
    $output[3]=$data->meiocheio;
    $output[4]=$data->meiovazio;
    $output[5]=$data->umquarto;
    $output[6]=$data->semprogresso;
    
    echo json_encode($output);

}

function getAtividade($conn, $id){
    $stmt = $conn->query("SELECT * FROM atividades WHERE id_atividade = $id");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

function setUsrAtividadeFinalizada($conn, $id_atividade){

    $stmt3 = $conn->prepare("UPDATE atividade SET cs_finalizada = 1 WHERE id_atividade = :id_atividade");

	$stmt3->bindParam(':id_atividade', $id_atividade);

	$stmt3->execute();
}

//verfifica progresso existente
function verifyAtividadeExec($conn,$data){
    
        $stmt = $conn->query("SELECT * FROM atividade_executada 
                            WHERE id_atividade = $data[1] AND dt_data = $data[3]");
        
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        if(!$data) return true;
        else {
            header('HTTP/1.1 403 Forbidden');
            return false;
        }
              
}
//insere progresso da atividade
function registraAtividadeExec($conn,$data){
    // Return error message
    //exit(json_encode(array('error' => 'Recebemos um Erro Central!')));
    //throw new \Exception('Nos falhamos!');

    $conn->setAttribute(PDO::ATTR_ERRMODE, $conn::ERRMODE_EXCEPTION);
    $e = null;
    try{
        $stmt = $conn->prepare("INSERT INTO atividade_executada (id_usuario, id_atividade, nb_qtd, dt_data)
        VALUES (:id_usuario, :id_atividade, :nb_qtd, :dt_data)");

        $stmt->bindParam(':id_usuario', $data[0]);
        $stmt->bindParam(':id_atividade', $data[1]);
        $stmt->bindParam(':nb_qtd', $data[2]);
        $stmt->bindParam(':dt_data', $data[3]);
        
        $stmt->execute();

        }
	catch(PDOException $e)
		{   
            // Set http header error
	    	//echo "Erro ao cadastrar progresso: " . $e->getMessage();
            header('HTTP/1.1 403 Forbidden');
            exit('Está tudo bem.');
		}
        
		if($e == null) echo "Progresso cadastrado!";
}

// return lista de funcionarios alocados no pedido
function getAlocacao($conn,$pid){
    $stmt = $conn->query("SELECT fa.*, fu.tx_nome, fu.tx_funcao FROM f_alocacao AS fa INNER JOIN funcionario AS fu ON fa.id_funcionario = fu.id_funcionario WHERE fa.id_pedido = $pid");
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

// return lista de funcionarios para lista base
function getFuncionarios($conn){
    $stmt = $conn->query("SELECT * FROM funcionario ORDER BY tx_nome ASC");
	$data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;    
}
