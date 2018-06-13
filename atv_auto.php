<?php
    require('conn.php');
	
	try{
	$stmt = $conn->query("SELECT tx_descricao FROM fornecimento");
    //fetch department names from the department table

		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
		
    $atividade_list = array();
	
    while($row = $stmt->fetch(PDO::FETCH_OBJ))
    {
        $atividade_list[] = $row->tx_descricao;
    }
    echo json_encode($atividade_list);
?>