
<!DOCTYPE html>
<html>
<head>
	<title>FireSystems.online</title>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<script src="./assets/js/jquery-3.7.1.min.js"></script>
	<script src="./assets/js/jquery.mask.js"></script>
	<script src="./assets/js/md5.min.js"></script>
	<style type="text/css">
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
// as variáveis login e senha recebem os dados digitados na página anterior

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); //

require("./DB/conn.php");
require("./controller/agentController.php");
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;

$key = include("./config/key.php");

$usuario = Auth::validateUser($conn);

JWT::encode($usuario, $key['jwt'],'HS256');

		$_SESSION['temp-k'] = $key['key'];
        if($_SESSION['catuser'] == 0) return header('Location: central.php');
        if($_SESSION['catuser'] == 1) return header('Location: central_ger.php');
        if($_SESSION['catuser'] == 2) return header('Location: central_usr.php');

?>
		</div>
		</div>
	</body>
</html>