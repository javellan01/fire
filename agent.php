
<!DOCTYPE html>
<html>
<head>
	<title>FireSystems.online</title>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<script src="./assets/js/jquery-3.3.1.min.js"></script>
	<script src="./assets/js/jquery.mask.js"></script>
	<script src="./assets/js/md5.min.js"></script>
	<style type="text/css">
		@import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300);
		* {
		  box-sizing: border-box;
		  margin: 0;
		  padding: 0;
		  font-weight: 400;
		}
		body {
		  font-family: 'Source Sans Pro', sans-serif;
		  color: white;
		  font-weight: 400;
		}
		body ::-webkit-input-placeholder {
		  /* WebKit browsers */
		  font-family: 'Source Sans Pro', sans-serif;
		  color: white;
		  font-weight: 300;
		}
		body :-moz-placeholder {
		  /* Mozilla Firefox 4 to 18 */
		  font-family: 'Source Sans Pro', sans-serif;
		  color: white;
		  opacity: 1;
		  font-weight: 300;
		}
		body ::-moz-placeholder {
		  /* Mozilla Firefox 19+ */
		  font-family: 'Source Sans Pro', sans-serif;
		  color: white;
		  opacity: 1;
		  font-weight: 300;
		}
		body :-ms-input-placeholder {
		  /* Internet Explorer 10+ */
		  font-family: 'Source Sans Pro', sans-serif;
		  color: white;
		  font-weight: 300;
		}
		p{
		  font-family: 'Source Sans Pro', sans-serif;
		  color: white;
		  font-weight: 300;

		  color: white;
		  font-size: 1.3em;
		  margin: 15px 0 10px;
		}
		.wrap {
		  background: #a60117 ;
		  background: linear-gradient(to bottom right, #c95 0%, #666 100%);
		  position: absolute;
		  top: 0;
		  left: 0;
		  width: 100%;
		  overflow: hidden;
		}
		
		.container {
		  max-width: 600px;
		  margin: 0 auto;
		  padding: 25vh 0 0;
		  height: 100vh;
		  text-align: center;
		}
		.container h1 {
		  font-size: 40px;/*
		  transition-duration: 1s;
		  transition-timing-function: ease-in-put;*/
		  font-weight: 400;
		}
		
		@-webkit-keyframes square {
		  0% {
		    -webkit-transform: translateY(0);
		            transform: translateY(0);
		  }
		  100% {
		    -webkit-transform: translateY(-700px) rotate(600deg);
		            transform: translateY(-700px) rotate(600deg);
		  }
		}
		@keyframes square {
		  0% {
		    -webkit-transform: translateY(0);
		            transform: translateY(0);
		  }
		  100% {
		    -webkit-transform: translateY(-700px) rotate(600deg);
		            transform: translateY(-700px) rotate(600deg);
		  }
		}
	</style>
</head>
<body>

	<div class="wrap">
		<div class="container">
			<h1>Admin FireSystems</h1>
				<p>Login Inválido!</p>
<?php 
// session_start inicia a sessão
session_start();
$login = $senha = $user = $catu = $uid = '';
// as variáveis login e senha recebem os dados digitados na página anterior

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); //

if(isset($_POST['usuario']) && isset($_POST['senha'])){

    $login = $_POST['usuario'];
    $senha = md5($_POST['senha']);
// as próximas 1 linhas são responsáveis em se conectar com o bando de dados.
require("./DB/conn.php");

// A variavel $result pega as varias $login e $senha, faz uma pesquisa na tabela de usuarios
$result = $conn->query("SELECT * FROM usuario WHERE tx_cpf = '".$login."' AND tx_password = '".$senha."'");
/* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */

if($result)
{
  while($row = $result->fetch(PDO::FETCH_OBJ)) {
     $var = Array(
        'usuario' =>   $row->tx_name,
        'email' =>     $row->tx_email,
        'categoria' => $row->nb_category_user,
		'contato' => $row->tx_telefone
	  
    );
	$uid = $row->id_usuario;
	$catu = $row->nb_category_user;
	$user = $row->tx_name;
    header('Content-Type: application/json');
    echo json_encode($var);
	echo 'Json encode OK!';
    /*
    echo "<script>var id_user=".$row['id_usuario']."</script>";
    echo "<script>var category_user=".$row['nb_category_user']."</script>";
    echo "<script>var name_user=".$row['tx_name']."</script>";
    echo "<script>var user_password=".$row['tx_password']."</script>";
    echo "<script>var user_email=".$row['tx_email']."</script>";
    */
  };
	$_SESSION['login'] = $login;
	$_SESSION['usuario'] = $user;
	$_SESSION['catuser'] = $catu;
	$_SESSION['userid'] = $uid;
	
	if($_SESSION['catuser'] == 0) header('Location: central.php');
	if($_SESSION['catuser'] == 1) header('Location: central_ger.php');
	if($_SESSION['catuser'] == 2) header('Location: central_usr.php');
	if($_SESSION['catuser'] == 3) header('Location: central_gst.php');
  
	}
}	
else{
	
unset ($_SESSION['login']);
unset ($_SESSION['usuario']);
unset ($_SESSION['catuser']);
unset ($_SESSION['userid']);
session_destroy();
echo "<p>Login Inválido!</p>";


header('Location: login.php');
sleep(1);
exit();

}
 
?>
		</div>
		</div>
	</body>
</html>