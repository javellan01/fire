
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

function novaCategoria($conn,$data){
    $e = null;
    try{
		$stmt = $conn->prepare("INSERT INTO categoria (id_categoria, tx_nome, tx_color) VALUES (:id_categoria, :tx_nome, :tx_color)");
		$stmt->bindParam(':id_categoria', $data[0]);
		$stmt->bindParam(':tx_nome', $data[1]);
		$stmt->bindParam(':tx_color', $data[2]);

		$stmt->execute();
				}
			catch(PDOException $e)
				{
				echo "Erro ao criar nova categoria! " . $e->getMessage();
				}
				
			if($e == null) echo "Nova Categoria Cadastrada com Sucesso!";

}

function updateCategoria($conn,$data){
    $e = null;
    try{
		$stmt = $conn->prepare("UPDATE categoria SET tx_nome = :tx_nome, tx_color = :tx_color WHERE id_categoria = :id_categoria");
		$stmt->bindParam(':id_categoria', $data[0]);
		$stmt->bindParam(':tx_nome', $data[1]);
        $stmt->bindParam(':tx_color', $data[2]);

		$stmt->execute();
				}
			catch(PDOException $e)
				{
				echo "Erro ao editar categoria! " . $e->getMessage();
				}
				
			if($e == null) echo "Categoria Editada com Sucesso!";

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
                    echo "Erro ao remover categoria! " . $e->getMessage();
                    }
                    
                if($e == null) echo "Categoria Removida!";

    }
    else{
        echo "Categoria não pode ser removida! <br> Esta categoria está sendo usada por ".$cound." atividades!";
    }
    

}

?>