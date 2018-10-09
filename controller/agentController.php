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

        $result = $conn->query("SELECT * FROM usuario WHERE tx_cpf = '".$login."' AND tx_password = '".$senha."'");                                    
       
        
        echo "<p>Login Cancelado!</p>";

        if($result)
        {   
            while($row = $result->fetch(PDO::FETCH_OBJ)) {
            $uid = $row->id_usuario;
	        $catu = $row->nb_category_user;
	        $user = $row->tx_name;
            
            };
           

            $_SESSION['login'] = $login;
            $_SESSION['usuario'] = $user;
            $_SESSION['catuser'] = $catu;
            $_SESSION['userid'] = $uid;
            
            if($_SESSION['catuser'] == 0) return header('Location: central.php');
            if($_SESSION['catuser'] == 1) return header('Location: central_ger.php');
            if($_SESSION['catuser'] == 2) return header('Location: central_usr.php');
            if($_SESSION['catuser'] == 3) return header('Location: central_gst.php');
 
        }
        else{
        unset ($_SESSION['login']);
        unset ($_SESSION['usuario']);
        unset ($_SESSION['catuser']);
        unset ($_SESSION['userid']);
        session_destroy();
        


        // header('Location: login.php');
        
        }
	    }
    }	
    else{
        
    // header('Location: login.php');
   
    }

    }
}
?>           