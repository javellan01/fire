
<?php

function data_usql($data) {
    $ndata = substr($data, 8, 2) ."/". substr($data, 5, 2) ."/".substr($data, 0, 4);
    return $ndata;
}

function time_usql($data) {
    $ndata = substr($data, 8, 2) ."/". substr($data, 5, 2) ."/".substr($data, 0, 4).substr($data, 10, 9);
    return $ndata;
}

// return lista de funcionarios para lista base
function getFuncionarios($conn){
    $stmt = $conn->query("SELECT * FROM funcionario AS fu ORDER BY tx_nome ASC");
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data;    
}
function getFuncionario($conn,$fid){
    $stmt = $conn->query("SELECT * FROM funcionario WHERE id_funcionario = $fid");
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data;    
}
// return lista das atividades de cada funcionario (id) para o modal
function getAFuncionarios($conn,$id){
    $stmt = $conn->query("SELECT fa.*, p.tx_codigo, p.tx_local, c.tx_nome AS cliente FROM f_alocacao AS fa INNER JOIN pedido AS p ON fa.id_pedido = p.id_pedido INNER JOIN cliente AS c ON p.id_cliente = c.id_cliente WHERE fa.id_funcionario = ".$id." ORDER BY fa.dt_inicio ASC;");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data; 
}

function getDFuncionarios($conn,$id){
    $stmt = $conn->query("SELECT * FROM sesmt WHERE id_funcionario = ".$id." ORDER BY tx_documento ASC;");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data; 
}

function newFuncionario($conn,$data){
    $e = null;
    try{
		$stmt = $conn->prepare("INSERT INTO funcionario (tx_nome, tx_cpf, tx_rg, tx_contato, dt_admissao, tx_funcao) VALUES (:tx_nome, :tx_cpf, :tx_rg, :tx_contato, :dt_admissao, :tx_funcao)");
		$stmt->bindParam(':tx_nome', $data[0]);
		$stmt->bindParam(':tx_cpf', $data[1]);
        $stmt->bindParam(':tx_rg', $data[2]);
        $stmt->bindParam(':tx_contato', $data[3]);
        $stmt->bindParam(':dt_admissao', $data[4]);
        $stmt->bindParam(':tx_funcao', $data[5]);

		$stmt->execute();
				}
			catch(PDOException $e)
				{
				echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Erro ao criar novo funcionário! " . $e->getMessage()."<button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>
                <span aria-hidden='true'>&times;</span></button></div>";
				}
				
			if($e == null) echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Funcionário Cadastrado com Sucesso!</strong><button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>
            <span aria-hidden='true'>&times;</span></button></div>";

}

function updateFuncionario($conn,$data){
    $e = null;
    try{
		$stmt = $conn->prepare("UPDATE funcionario SET tx_nome = :tx_nome, tx_cpf = :tx_cpf, tx_rg = :tx_rg, tx_contato = :tx_contato, dt_admissao = :dt_admissao, tx_funcao = :tx_funcao WHERE id_funcionario = :id_funcionario");
		$stmt->bindParam(':tx_nome', $data[0]);
		$stmt->bindParam(':tx_cpf', $data[1]);
        $stmt->bindParam(':tx_rg', $data[2]);
        $stmt->bindParam(':tx_contato', $data[3]);
        $stmt->bindParam(':dt_admissao', $data[4]);
        $stmt->bindParam(':tx_funcao', $data[5]);
        $stmt->bindParam(':id_funcionario', $data[6]);

		$stmt->execute();
				}
			catch(PDOException $e)
				{
				echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Erro ao editar funcionário! " . $e->getMessage()."<button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>
                <span aria-hidden='true'>&times;</span></button></div>";
				}
				
			if($e == null) echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Funcionário Editado com Sucesso!</strong><button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>
            <span aria-hidden='true'>&times;</span></button></div>";

}
?>