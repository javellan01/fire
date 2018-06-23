<?php
$hostname = "mysql.firesystems.com.br";
$usuario = "firesystems";
$senha = "fire2014";
$banco = "firesystems";
try{
    $con = new pdo( 'mysql:host=mysql.firesystems.com.br;dbname=firesystems',
                    $usuario,
                    $senha,
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    die(json_encode(array('outcome' => true)));
}
catch(PDOException $ex){
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
}
?>