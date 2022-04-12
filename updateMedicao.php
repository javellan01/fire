
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

if($_POST['updateMedicao'] == 1){
$data = array();
$items = count($_POST['Atividade']);

for ($i=0; $i < $items; $i++) { 
    $data[$i]['Atividade'] = $_POST['Atividade'][$i];
    $data[$i]['Id_pedido'] = $_POST['Id_pedido'][$i];
    $data[$i]['Valor'] = $_POST['Valor'][$i];
    $data[$i]['Nb_ordem'] = $_POST['Nb_ordem'][$i];
}

updateMedicao($conn, $data);

}
?>