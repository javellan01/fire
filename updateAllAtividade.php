
<?php
 session_start();
 if(!isset($_SESSION["login"]) || !isset($_SESSION["usuario"]) || !isset($_SESSION["userid"])) 
     { 
 // Usuário não logado! Redireciona para a página de login 
     header("Location: login.php"); 
     exit; 
 } 

require("./DB/conn.php");
require("./controller/atividadesController.php");

function data_sql($data) {
    $ndata = substr($data, 6, 4) ."-". substr($data, 3, 2) ."-".substr($data, 0, 2);
    return $ndata;
}


if($_POST['updateAllAtividade'] == 1 && ($_POST['json_data'])){

$postdata = json_decode($_POST['json_data']);
$items = count($postdata[9]);
$data = array();

for ($i=0; $i < $items; $i++) { 

    $data[$i]['Indice'] = $postdata[0][$i];
    $data[$i]['Atividade'] = $postdata[9][$i];
    $data[$i]['Categoria'] = $postdata[2][$i];
    $data[$i]['Tipo'] = $postdata[4][$i];
    $data[$i]['Descricao'] = $postdata[3][$i];
    $data[$i]['Inicio'] = data_sql($postdata[7][$i]);
    $data[$i]['Fim'] = data_sql($postdata[8][$i]);
    $data[$i]['Status'] = $postdata[1][$i];
    $data[$i]['Valor'] = $postdata[6][$i];
    $data[$i]['Qtd'] = $postdata[5][$i];
    
}

 updateAllAtividade($conn, $data);

}
?>