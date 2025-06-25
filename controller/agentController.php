<?php 

class Auth
    {
    private $conn;
    private $login;
    private $senha;
    private $user;
    private $catu;
    private $uid;
    
    public static function validateUser($conn){
        if(isset($_POST['usuario']) && isset($_POST['senha'])){
            if($_POST['usuario'] !== ''){

            $login = $_POST['usuario'];
            $senha = md5($_POST['senha']);

        $result = $conn->query("SELECT id_usuario, nb_category_user, tx_name FROM usuario WHERE tx_cpf = '".$login."' AND tx_password = '".$senha."'");        
        $data = $result->fetch(PDO::FETCH_ASSOC);

        if($result)
        {   
            $uid = $data['id_usuario'];
	        $catu = $data['nb_category_user'];
	        $user = $data['tx_name'];
            };

            $_SESSION['login'] = $login;
            $_SESSION['usuario'] = $user;
            $_SESSION['catuser'] = $catu;
            $_SESSION['userid'] = $uid;
            
            return $data;

        }
        else{
        $_SESSION = [];
        session_destroy();
        }

	}
    }	

    public static function accessControl($catuser,$level){
        
    if(isset($_SESSION['catuser'])){
        if($catuser != $level){
            if($_SESSION['catuser'] == 0) return header('Location: central.php');
            if($_SESSION['catuser'] == 1) return header('Location: central_ger.php');
            if($_SESSION['catuser'] == 2) return header('Location: central_usr.php');
        }
    }
    else session_destroy();
    }
}


?>           