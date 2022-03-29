
<?php

function data_usql($data) {
    $ndata = substr($data, 8, 2) ."/". substr($data, 5, 2) ."/".substr($data, 0, 4);
    return $ndata;
}

function time_usql($data) {
    $ndata = substr($data, 8, 2) ."/". substr($data, 5, 2) ."/".substr($data, 0, 4).substr($data, 10, 9);
    return $ndata;
}

// return objeto de categorias para lista base
function getCategorias($conn){

    $stmt = $conn->query("SELECT * FROM categoria ORDER BY id_categoria ASC");

	$data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;  

}

// verifica uso das categoria display para a lista
function checkCategorias($conn){

    $cats = getCategorias($conn);

    $counter = array();

    foreach($cats AS $cat){
        
        
        $stmt = $conn->query("SELECT COUNT(id_categoria) AS count FROM atividade WHERE id_categoria = ".$cat->id_categoria);

        $data = $stmt->fetch(PDO::FETCH_OBJ);

        $counter[$cat->id_categoria] = $data->count;
    }

    return $counter; 

}

// verifica uso da categoria
function checkCategoria($conn,$id){

    $stmt = $conn->query("SELECT * FROM atividade WHERE id_categoria = ".$id);

    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    $count = count($data);

    return $count; 

}

function newCategoria($conn,$data){
    $e = null;
    try{
		$stmt = $conn->prepare("INSERT INTO categoria (id_categoria, tx_nome) VALUES (:id_categoria, :tx_nome)");
		$stmt->bindParam(':id_categoria', $data[0]);
		$stmt->bindParam(':tx_nome', $data[1]);

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

function updateCategoria($conn,$data){
    $e = null;
    try{
		$stmt = $conn->prepare("UPDATE categoria SET tx_nome = :tx_nome WHERE id_categoria = :id_categoria");
		$stmt->bindParam(':id_categoria', $data[0]);
		$stmt->bindParam(':tx_nome', $data[1]);

		$stmt->execute();
				}
			catch(PDOException $e)
				{
				echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Erro ao renomear categoria! " . $e->getMessage()."<button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>
                <span aria-hidden='true'>&times;</span></button></div>";
				}
				
			if($e == null) echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Categoria Renomeada com Sucesso!</strong><button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>
            <span aria-hidden='true'>&times;</span></button></div>";

}

function removeCategoria($conn,$id){
    
    $count = checkCategoria($conn,$id);

    if($count == 0){
        $e = null;

        try{
            $stmt = $conn->prepare("DELETE FROM categoria WHERE id_categoria = :id_categoria");
            $stmt->bindParam(':id_categoria', $id);
    
            $stmt->execute();
                    }
                catch(PDOException $e)
                    {
                    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Erro ao remover categoria! " . $e->getMessage()."<button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>
                    <span aria-hidden='true'>&times;</span></button></div>";
                    }
                    
                if($e == null) echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Categoria Removida!</strong><button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>
                <span aria-hidden='true'>&times;</span></button></div>";

    }
    else{
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Categoria não pode ser removida! <br> Esta categoria está sendo usada por ".$cound." atividades!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>
                    <span aria-hidden='true'>&times;</span></button></div>";
    }
    

}

?>