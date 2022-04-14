
<?php
 session_start();
 if(!isset($_SESSION["login"]) || !isset($_SESSION["usuario"]) || !isset($_SESSION["userid"])) 
     { 
 // Usuário não logado! Redireciona para a página de login 
     header("Location: login.php"); 
     exit; 
 } 

 function data_sqlS($data) {
    $ndata = substr($data, 6, 4) ."-". substr($data, 3, 2) ."-".substr($data, 0, 2);
    return $ndata;
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

if($_POST['finalizarMedicao'] == 1){

    if(!$_POST['DadoNota']) {
        header('HTTP/1.1 403 Forbidden');
        exit('Por favor preencher o número da nota!');
    }

    $data = array();
    
    $data['cs_finalizada'] = 1;
    $data['id_medicao'] = $_POST['id_medicao'];
    $data['DadoNota'] = $_POST['DadoNota'];
    $data['EmData'] = data_sqlS($_POST['EmData']);
    $data['VeData'] = data_sqlS($_POST['VeData']);
    

    finalizarMedicao($conn, $data);
    
    }

if($_POST['excluirMedicao']){

$mid = (int)$_POST['excluirMedicao'];

excluirMedicao($conn, $mid);

}


?>