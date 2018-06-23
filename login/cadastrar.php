<?php 

session_start();

$login  = $_POST['usuario'];
$cpf    = $_POST['cpf'];
$senha  = md5($_POST['senha']);


try{
    $con = new pdo( 'mysql:host=mysql.firesystems.com.br;dbname=firesystems',
                    "firesystems", "fire2014",
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(PDOException $ex){
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
}
 
$sql = "INSERT INTO usuario(tx_name, 
                            tx_password,
                            tx_cpf) 
        VALUES (            :tx_name, 
                            :tx_password, 
                            :tx_cpf)";
$stmt = $con->prepare($sql);
                                              
$stmt->bindParam(':tx_name', $login, PDO::PARAM_STR);       
$stmt->bindParam(':tx_password', $senha, PDO::PARAM_STR); 
$stmt->bindParam(':tx_cpf', $cpf, PDO::PARAM_STR); 
                                      
$stmt->execute();
echo $stmt->rowCount();

?>