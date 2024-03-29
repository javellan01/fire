
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

function getClientes($conn){
    $stmt = $conn->query("SELECT * FROM cliente ORDER BY tx_nome ASC");
	$data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;    
}

function getCliente($conn,$cid){
    $stmt = $conn->query("SELECT * FROM cliente WHERE id_cliente = $cid");
	$data = $stmt->fetch(PDO::FETCH_OBJ);

    return $data;    
}


function getPedidosCliente($conn,$cid){
    $stmt = $conn->query("SELECT * FROM pedido AS p INNER JOIN v_sum_pedido_total AS vp ON p.id_pedido = vp.id_pedido WHERE p.id_cliente = $cid");
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

function getUserCliente($conn,$cid){
    $stmt = $conn->query("SELECT *, CONVERT_TZ(last_access,'+00:00','-04:00') AS tz_last FROM cliente_usr WHERE id_cliente = $cid");
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

function showUserAccess($nb_category_user){
    if($nb_category_user == 0) return 'Acesso Financeiro'; 
    if($nb_category_user == 1) return 'Somente Progresso'; 
}

function getUsrPedidosAtivos($conn,$cuid){
    $stmt = $conn->query("SELECT COUNT(id_cliente_usr) FROM pedido WHERE cs_estado = 0 AND id_cliente_usr = $cuid AND id_cliente != 0");
    $data = $stmt->fetch(PDO::FETCH_COLUMN);

    return $data[0];
}

function newCliente($conn,$data){
    $e = null;
    try{
        $stmt = $conn->prepare("INSERT INTO cliente (tx_nome, tx_cnpj, tx_password) VALUES (:tx_nome, :tx_cnpj, :tx_password)");
        $stmt->bindParam(':tx_nome', $data[0]);
        $stmt->bindParam(':tx_cnpj', $data[1]);
        $stmt->bindParam(':tx_password', $data[2]);
        
        $stmt->execute();
            }
        catch(PDOException $e)
            {
            $e->getMessage();
            }    
           
}  
    
function updateCliente($conn,$data){
    try{
        $stmt = $conn->prepare("UPDATE cliente SET tx_nome = :tx_nome, tx_cnpj = :tx_cnpj WHERE id_cliente = :id_cliente");
        $stmt->bindParam(':tx_nome', $data[0]);
        $stmt->bindParam(':tx_cnpj', $data[1]);
        $stmt->bindParam(':id_cliente', $data[2]);
        
        $stmt->execute();
            }
        catch(PDOException $e)
            {
            $e->getMessage();
            }  


}
?>