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

function getPedidoData($conn, $pid){
    $stmt = $conn->query("SELECT p.*, vspt.medido_total, (( p.nb_valor / 100) * p.nb_retencao) AS retencao, c.tx_nome 
    FROM pedido p 
    INNER JOIN cliente c ON p.id_cliente = c.id_cliente 
    INNER JOIN v_sum_pedido_total vspt ON p.id_pedido = vspt.id_pedido 
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

    if(count($data) == 0){
        return true;
    } else{ 
        $e = '
                <h5 class="card-title">Comentário:</h5>
                <p class="card-text text-primary">'.$data[0]->tx_comentario.'</p>';
        return $e;

    }

    return $data;
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

function getCategoriaPedido($conn,$pid){
    $stmt = $conn->query("SELECT c.* FROM atividade a  
        INNER JOIN categoria c ON a.id_categoria=c.id_categoria	WHERE a.id_pedido = $pid GROUP BY a.id_categoria ASC");
        
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

function getCategoriaSum($conn,$pid,$cid){
    $stmt = $conn->query("SELECT FORMAT(((progresso / nbvalor) *100),1) as execpercent, 
    FORMAT(((valorsum / nbvalor) *100),2) as medpercent, id_categoria, nbvalor, valorsum, qtdsum, nbqtd, progresso, v_unit 
    FROM (SELECT id_categoria, SUM(nb_valor) nbvalor, SUM(valor_sum) valorsum, SUM(qtd_sum) qtdsum, SUM(nb_qtd) nbqtd, SUM(progresso) progresso, v_unit 
            FROM v_categoria_sums 
            WHERE id_pedido = $pid AND id_categoria = $cid 
            GROUP BY id_categoria) AS tb");

    $data = $stmt->fetch(PDO::FETCH_OBJ);

    return $data;
}

function getAtividades($conn,$pid,$cid){
    $stmt = $conn->query("SELECT b.*, FORMAT(((b.qtd_sum/b.nb_qtd)*100),1) AS percent, 
    FORMAT(((b.valor_sum/b.nb_valor)*100),2) AS medpercent, 
    FORMAT(((b.progresso/b.nb_valor)*100),1) AS execpercent 
    FROM (SELECT a.*, v1.qtd_sum, v1.progresso, v1.valor_sum 
            FROM atividade a 
            LEFT JOIN v_categoria_sums v1 ON a.id_atividade=v1.id_atividade 
            WHERE a.id_pedido = $pid AND a.id_categoria = $cid) AS b");

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

function medirAtividades($conn,$pid){
    $stmt = $conn->query("SELECT a.id_atividade, a.id_idx, a.tx_descricao, c.tx_nome, vsam.valor_sum, vsam.nb_valor 
    FROM atividade a 
	INNER JOIN categoria c ON a.id_categoria = c.id_categoria
	INNER JOIN v_sum_atividade_medd vsam ON a.id_atividade = vsam.id_atividade
	WHERE a.id_pedido = $pid AND cs_medida = 0");

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}
//get o user Convidado de acordo com o cliente
function getUsersCliente($conn,$cid){
    $stmt = $conn->query("SELECT tx_nome,id_usuario FROM cliente_usr WHERE id_cliente = $cid");
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}
//get os users da FireSys
function getUsers($conn){
    $stmt = $conn->query("SELECT tx_name,id_usuario FROM usuario");
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}
//get os users NOT admin da FireSys
function getUsuarios($conn){
    $stmt = $conn->query("SELECT tx_name,id_usuario FROM usuario WHERE NOT nb_category_user = 0");
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}
//desaloca os dados do pedido do cliente
function removePedido($conn,$pid){
    $stmt = $conn->prepare("UPDATE pedido SET id_cliente = 0 WHERE id_pedido = :pid");
    $stmt->bindParam(':pid', $pid);
    $stmt->execute();
}
//update dos dados do pedido
function updatePedido($conn,$data){
    $e = null;
    try{
		$stmt = $conn->prepare("UPDATE pedido SET tx_codigo = :tx_codigo, tx_local = :tx_local, tx_descricao = :tx_descricao, nb_valor = :nb_valor, nb_retencao = :nb_retencao, cs_estado = :cs_estado, dt_idata = :dt_idata, dt_tdata = :dt_tdata, id_usu_resp = :id_usu_resp, id_cliente_usr = :id_cliente_usr WHERE id_pedido = :id_pedido");
		$stmt->bindParam(':tx_codigo', $data[0]);
		$stmt->bindParam(':tx_local', $data[1]);
        $stmt->bindParam(':tx_descricao', $data[2]);
        $stmt->bindParam(':nb_valor', $data[3]);
        $stmt->bindParam(':nb_retencao', $data[4]);
        $stmt->bindParam(':cs_estado', $data[5]);
        $stmt->bindParam(':dt_idata', $data[6]);
        $stmt->bindParam(':dt_tdata', $data[7]);
        $stmt->bindParam(':id_usu_resp', $data[8]);
        $stmt->bindParam(':id_cliente_usr', $data[9]);
        $stmt->bindParam(':id_pedido', $data[10]);

		$stmt->execute();
				}
			catch(PDOException $e)
				{
				echo "Erro ao editar pedido! " . $e->getMessage();
				}
				
			if($e == null) echo "Pedido Editado com Sucesso!";

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
    //exit('Ok tudo bem.');
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
//update dos dados da atividade 
function updateAtividade($conn, $data){
    $e = null;
    try{
        $stmt = $conn->prepare("UPDATE atividade 
        SET tx_descricao = :tx_descricao, tx_tipo = :tx_tipo, nb_qtd = :nb_qtd, nb_valor = :nb_valor, dt_inicio = :dt_inicio , dt_fim = :dt_fim, id_categoria = :id_categoria, cs_finalizada = :cs_finalizada, id_idx = :id_idx  
        WHERE id_atividade = :id_atividade");

        $stmt->bindParam(':tx_descricao',$data[0]); 
        $stmt->bindParam(':tx_tipo',$data[1]); 
        $stmt->bindParam(':nb_qtd',$data[2]); 
        $stmt->bindParam(':nb_valor',$data[3]); 
        $stmt->bindParam(':dt_inicio',$data[4]); 
        $stmt->bindParam(':dt_fim',$data[5]); 
        $stmt->bindParam(':id_atividade',$data[6]); 
        $stmt->bindParam(':id_categoria',$data[7]); 
        $stmt->bindParam(':cs_finalizada',$data[8]); 
        $stmt->bindParam(':id_idx',$data[9]); 
        
       $stmt->execute();
       
      }
      catch(PDOException $e){
         echo  $e->getMessage();
      }
      if($e == null) echo "Atualizado com Sucesso!";
}

function updateAllAtividade($conn, $data){
    $e = null;
    try{
        $conn->beginTransaction();

        $stmt = $conn->prepare("UPDATE atividade 
        SET tx_descricao = :tx_descricao, tx_tipo = :tx_tipo, nb_qtd = :nb_qtd, nb_valor = :nb_valor, dt_inicio = :dt_inicio, dt_fim = :dt_fim, id_categoria = :id_categoria, cs_finalizada = :cs_finalizada, id_idx = :id_idx  
        WHERE id_atividade = :id_atividade");

        foreach($data as $atividade){
            $stmt->bindParam(':tx_descricao',$atividade['Descricao']); 
            $stmt->bindParam(':tx_tipo',$atividade['Tipo']); 
            $stmt->bindParam(':nb_qtd',$atividade['Qtd']); 
            $stmt->bindParam(':nb_valor',$atividade['Valor']); 
            $stmt->bindParam(':dt_inicio',$atividade['Inicio']); 
            $stmt->bindParam(':dt_fim',$atividade['Fim']); 
            $stmt->bindParam(':id_atividade',$atividade['Atividade']); 
            $stmt->bindParam(':id_categoria',$atividade['Categoria']); 
            $stmt->bindParam(':cs_finalizada',$atividade['Status']); 
            $stmt->bindParam(':id_idx',$atividade['Indice']); 
            
            $stmt->execute();
        }
        $conn->commit();
      }
      catch(Exception $e){
         $conn->rollback();
         throw $e;
      }
      if($e == null) echo "Todas Atividades foram Salvas com Sucesso!";
}

function updateMedicao($conn, $data){
    $e = null;
    $conn->setAttribute(PDO::ATTR_ERRMODE, $conn::ERRMODE_EXCEPTION);
    try{
        $conn->beginTransaction();

        $stmt = $conn->prepare("UPDATE atividade_medida 
        SET nb_valor = :nb_valor  
        WHERE nb_ordem = :nb_ordem AND id_pedido = :id_pedido AND id_atividade = :id_atividade");

        foreach($data as $atividade){
            $stmt->bindParam(':id_pedido',$atividade['Id_pedido']); 
            $stmt->bindParam(':nb_ordem',$atividade['Nb_ordem']); 
            $stmt->bindParam(':nb_valor',$atividade['Valor']); 
            $stmt->bindParam(':id_atividade',$atividade['Atividade']); 
            
            $stmt->execute();
        }
        $conn->commit();
      }
      catch(Exception $e){
         $conn->rollback();
         throw $e;
      }
      if($e == null) echo "Todos os Valores foram Salvos com Sucesso!";
}
//remove medicao e atividades medidas associadas atividades.php
function excluirMedicao($conn,$mid){
    $e=null;
    $stmt = $conn->query("SELECT id_pedido, nb_ordem FROM medicao WHERE id_medicao = $mid");
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    
    try{
        $stmt = $conn->prepare("DELETE FROM atividade_medida WHERE id_pedido = :id_pedido AND nb_ordem = :nb_ordem");
        $stmt->bindParam(':id_pedido',$result->id_pedido);
        $stmt->bindParam(':nb_ordem',$result->nb_ordem);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM medicao WHERE id_medicao = :id_medicao");
        $stmt->bindParam(':id_medicao',$mid);
        $stmt->execute();
        
        }
        catch(PDOException $e){
            echo $e->getMessage();
            }
            if($e == null) echo "Medição Excluída com Sucesso!";
            
}

//exclude de atividade verficica tambem se há pendencia antes de excluir detpedido.php
function excluirAtividade($conn,$data){
    $e = null;

    $stmt = $conn->query("SELECT count(*) AS existe FROM atividade_executada WHERE id_atividade = $data");
    $result = $stmt->fetch(PDO::FETCH_OBJ);

    if($result->existe == 0){
        try{
            $stmt = $conn->prepare("DELETE FROM atividade WHERE id_atividade = :id_atividade");
            $stmt->bindParam(':id_atividade',$data); 
            $stmt->execute();
            }
            catch(PDOException $e){
                echo  $e->getMessage();
                }
                if($e == null) echo "Atividade Excluída com Sucesso!";
                
        }
        else echo "Erro: Atividade com Execução Registrada!";
   
}
//criar multiplas atividades
function createMultipleAtividades($conn,$number,$data){
    $e=null;
    try{
        $query = "INSERT INTO atividade (tx_descricao,id_categoria,id_pedido) VALUES ";

        for($i = 1; $i <= $number; $i++ )  {
            $query .= " ('Nova Atividade $i', $data[1], $data[0]),";
               
        }
        $query = substr_replace($query, "", -1);
        $i--;
        $stmt = $conn->prepare($query);      
        $stmt->execute();
            
        }
        catch(PDOException $e){
            echo  $e->getMessage();
            }
        if($e == null) echo $i." Atividades Cadastradas com Sucesso!";
        //if($e == null) echo $i." Atividades Cadastradas com Sucesso!";

}
//retur lista de convidados que acessam o sistema
function getAcessoConvidado($conn,$pid){
    $stmt = $conn->query("SELECT ap.*, cu.tx_nome, cu.tx_email, cu.tx_contato, cu.nb_category_user FROM acesso_pedido AS ap 
                        INNER JOIN cliente_usr AS cu ON ap.id_cliente_usr = cu.id_usuario 
                        WHERE ap.id_usuario IS NULL AND ap.id_pedido = $pid");
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

//retur lista de users fire que acessam o sistema
function getAcessoUsuario($conn,$pid){
    $stmt = $conn->query("SELECT ap.*, u.tx_name FROM acesso_pedido AS ap 
                        INNER JOIN usuario AS u ON ap.id_usuario = u.id_usuario 
                        WHERE ap.id_cliente_usr IS NULL AND ap.id_pedido = $pid");
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}
//Garante ao Usuario Acesso ao Pedido
function grantAcessoUsuario($conn,$data){
    $e = null;
    try{
    $stmt = $conn->prepare("INSERT INTO acesso_pedido (id_usuario, id_pedido) VALUES (:id_usuario, :id_pedido)");
	
    $stmt->bindParam(':id_usuario',$data[0]); 
    $stmt->bindParam(':id_pedido',$data[1]); 

    $stmt->execute();
    }
    catch(PDOException $e){
        echo  $e->getMessage();
        }
        if($e == null) echo "Acesso Liberado!";
}

//Garante ao Convidado Acesso ao Pedido
function grantAcessoConvidado($conn,$data){
    $e = null;
    try{
    $stmt = $conn->prepare("INSERT INTO acesso_pedido (id_cliente_usr, id_pedido) VALUES (:id_cliente_usr, :id_pedido)");
	
    $stmt->bindParam(':id_cliente_usr',$data[0]); 
    $stmt->bindParam(':id_pedido',$data[1]); 

    $stmt->execute();
    }
    catch(PDOException $e){
        echo  $e->getMessage();
        }
        if($e == null) echo "Acesso Liberado!";
}

 // Remove acesso ao Usuario no Pedido
 function removeAcessoUsuario($conn,$data){
    $e = null;
    try{
    $stmt = $conn->prepare("DELETE FROM acesso_pedido WHERE id_usuario = :id_usuario AND id_pedido = :id_pedido");
	
    $stmt->bindParam(':id_usuario',$data[0]); 
    $stmt->bindParam(':id_pedido',$data[1]); 

    $stmt->execute();
    }
    catch(PDOException $e){
        echo  $e->getMessage();
        }
        if($e == null) echo "Acesso Removido com Sucesso!";
}
 // Remove acesso ao Convidado no Pedido
function removeAcessoConvidado($conn,$data){
    $e = null;
    try{
    $stmt = $conn->prepare("DELETE FROM acesso_pedido WHERE id_cliente_usr = :id_cliente_usr AND id_pedido = :id_pedido");
	
    $stmt->bindParam(':id_cliente_usr',$data[0]); 
    $stmt->bindParam(':id_pedido',$data[1]); 

    $stmt->execute();
    }
    catch(PDOException $e){
        echo  $e->getMessage();
        }
        if($e == null) echo "Acesso Removido com Sucesso!";
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
 // Aloca Funcionario no Pedido
function alocaFuncionario($conn,$data){
    $e = null;
    try{
    $stmt = $conn->prepare("INSERT INTO f_alocacao (id_funcionario, id_pedido) VALUES (:id_funcionario, :id_pedido)");
	
    $stmt->bindParam(':id_funcionario',$data[0]); 
    $stmt->bindParam(':id_pedido',$data[1]); 

    $stmt->execute();
    }
    catch(PDOException $e){
        echo  $e->getMessage();
        }
        if($e == null) echo "Alocado com Sucesso!";
}
 // Remove Funcionario alocado no Pedido
function removeFuncionario($conn,$data){
    $e = null;
    try{
    $stmt = $conn->prepare("DELETE FROM f_alocacao WHERE id_funcionario = :id_funcionario AND id_pedido = :id_pedido");
	
    $stmt->bindParam(':id_funcionario',$data[0]); 
    $stmt->bindParam(':id_pedido',$data[1]); 

    $stmt->execute();
    }
    catch(PDOException $e){
        echo  $e->getMessage();
        }
        if($e == null) echo "Removido com Sucesso!";
}
