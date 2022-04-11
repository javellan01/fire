
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

if($_POST['updateAllAtividade'] == 1){
$postdata = array();
$items = count($_POST['Atividade']);

for ($i=0; $i < $items; $i++) { 
    $postadata[$i]['Atividade'] = $_POST['Atividade'][$i];
    $postadata[$i]['Categoria'] = $_POST['Categoria'][$i];
    $postadata[$i]['Tipo'] = $_POST['Tipo'][$i];
    $postadata[$i]['Descricao'] = $_POST['Descricao'][$i];
    $postadata[$i]['Inicio'] = data_sql($_POST['Inicio'][$i]);
    $postadata[$i]['Fim'] = data_sql($_POST['Fim'][$i]);
    $postadata[$i]['Status'] = $_POST['Status'][$i];
    $postadata[$i]['Valor'] = $_POST['Valor'][$i];
    $postadata[$i]['Qtd'] = $_POST['Qtd'][$i];
}

updateAllAtividade($conn, $postadata);

}
?>