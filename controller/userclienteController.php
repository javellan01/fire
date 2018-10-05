<?php
function data_usql($data) {
    $ndata = substr($data, 8, 2) ."/". substr($data, 5, 2) ."/".substr($data, 0, 4);
    return $ndata;
}

function time_usql($data) {
    $ndata = substr($data, 8, 2) ."/". substr($data, 5, 2) ."/".substr($data, 0, 4).substr($data, 10, 9);
    return $ndata;
}

function getUserCliente($conn,$cuid){
    $stmt = $conn->query("SELECT *, CONVERT_TZ(last_access,'+00:00','-04:00') AS tz_last FROM cliente_usr WHERE id_usuario = $cuid");
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data[0];
}

function newClienteUser($conn,$data){
    $e = null;
    try{
		$stmt = $conn->prepare("INSERT INTO cliente_user (tx_nome,  tx_email,  tx_contato,  id_cliente, tx_password) VALUES (:tx_nome, :tx_email, :tx_contato, :id_cliente, :tx_password)");
		$stmt->bindParam(':tx_nome', $data[0]);
		$stmt->bindParam(':tx_email', $data[1]);
        $stmt->bindParam(':tx_contato', $data[2]);
        $stmt->bindParam(':id_cliente', $data[3]);
        $stmt->bindParam(':tx_password', $data[4]);

		$stmt->execute();
				}
			catch(PDOException $e)
				{
				echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Erro ao criar usuário! " . $e->getMessage()."<button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>
                <span aria-hidden='true'>&times;</span></button></div>";
				}
				
			if($e == null) echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Novo Usuário Inserido com Sucesso!</strong><button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>
            <span aria-hidden='true'>&times;</span></button></div>";

}

function updateClienteUser($conn,$data){
    $e = null;
    try{
		$stmt = $conn->prepare("UPDATE cliente_user SET tx_nome = :tx_nome, tx_email = :tx_email, tx_contato = :tx_contato WHERE id_usuario = :id_funcionario");
		$stmt->bindParam(':tx_nome', $data[0]);
		$stmt->bindParam(':tx_email', $data[1]);
        $stmt->bindParam(':tx_contato', $data[2]);
        $stmt->bindParam(':id_usuario', $data[3]);

		$stmt->execute();
				}
			catch(PDOException $e)
				{
				echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Erro ao editar usuário! " . $e->getMessage()."<button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>
                <span aria-hidden='true'>&times;</span></button></div>";
				}
				
			if($e == null) echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Usuário Editado com Sucesso!</strong><button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>
            <span aria-hidden='true'>&times;</span></button></div>";

}
?>