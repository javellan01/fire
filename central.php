<?php 
	// Inicia sessões
	session_start(); 
	//echo session_status(); 
	// Verifica se existe os dados da sessão de login 
	if(!isset($_SESSION["login"]) || !isset($_SESSION["usuario"])) 
		{ 
	// Usuário não logado! Redireciona para a página de login 
		header("Location: login.php"); 
		exit; 
	} 

	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: 0"); //

	require("./controller/agentController.php");
	Auth::accessControl($_SESSION['catuser'],0);

?>
<!DOCTYPE html>
<html><head>
	<meta lang='pt-BR'>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Admin | FireSystems</title>
	<link rel="stylesheet" href="./assets/css/toastr.min.css">
	<link rel="stylesheet" href="./assets/css/jquery-ui.css">
	<link rel="stylesheet" href="./dist/css/coreui.min.css">
	<link rel="stylesheet" href="./dist/css/coreui-icons.min.css">
	<link rel="stylesheet" href="./dist/css/fullcalendar.min.css">
	<style>
      .app-body { overflow-x: initial;}
	  .fc-sat {background-color: #eee;}
	  .fc-sun {background-color: #eee;}
	  .fc-week-number {background-color: #09568d; color: white;}
	  .fc-day-top {color: #09568d;}
	  .fc-day-header {color: #09568d;}
	  th {font-weight: normal;}
    </style>
		<script src="./assets/js/jquery-3.6.0.min.js"></script>
		<script src="./assets/js/jquery-ui.min.js"></script>
		<script src="./assets/js/jquery.ajax.form.js"></script>
		<script src="./assets/js/jquery.mask.min.js"></script>
		<script src="./assets/js/popper.min.js"></script>
		<script src="./assets/js/moment.min.js"></script>
		<script src="./dist/js/bootstrap.js"></script>
		<script src="./assets/js/perfect-scrollbar.min.js"></script>
		<script src="./assets/js/coreui.min.js"></script>
		<script src="./assets/js/docs.min.js"></script>
		<script src="./assets/js/vue.min.js"></script>
		<script src="./assets/js/toastr.min.js"></script>
		<script src="./dist/js/fullcalendar.min.js"></script>
		<script src="./dist/js/locale/pt-br.js"></script>
		
	<!-- AJAX Scriping for loading dynamically PHP on server -->
		<script src="./assets/js/central.js"></script>
	

</head>
<?php

require("./DB/conn.php");	
require("./controller/centralController.php");	

?>
<body class="app header-fixed sidebar-md-show sidebar-fixed">
<header class='app-header navbar' style='background: #2f353a; border-bottom: 4px solid #a60117;'>
	<button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
	<span class="navbar-toggler-icon"></span>
	</button>
		<a class="navbar-brand ml-3" href="http://www.firesystems-am.com.br/">
		<img src="./img/fire.png" alt="FIRE AM" width="150" height="50">
		</a>
			<ul class="nav navbar-nav ml-auto">
				<li class="nav-item px-3">
				<a class="nav-link text-warning" style="font-weight: 500;" href="javascript:loadPhp('perfil.php');"><i class="nav-icon cui-info"></i><?php echo " ".$_SESSION['usuario'];?></a>
				</li>
			</ul>
			<ul class="nav navbar-nav">
				<li class="nav-item px-3">
				<a class="btn btn-light" href="logout.php?token=<?php echo md5(session_id());?>">Logout <i class="nav-icon cui-account-logout"></i></a>
				</li>
			</ul>
</header>
<div class="app-body">	
	<div class="sidebar">
	  <nav class="sidebar-nav" style="font-weight: 480;">
		<ul class="nav">
		  <li class="nav-title" id="fecharBtn"><strong>Sistema FireSystems</strong></li>
		  
		  <li class="nav-item nav-dropdown ">
			<a class="nav-link nav-dropdown-toggle text-warning" href="#">
			  <strong><i class="nav-icon cui-layers"></i> Sistema ADMIN </strong> 
			  
			</a>
			<ul class="nav-dropdown-items">
				<li class="nav-item">
				<a class="nav-link text-light" href="central.php">
				  <i class="nav-icon cui-home"></i>Central
				</a>
			  </li>
				<li class="nav-item">
				<a class="nav-link text-light" href="javascript:loadPhp('pedidos.php');">
				  <i class="nav-icon cui-list"></i>Situação Pedidos
				</a>
			  </li>
			  <li class="nav-item ">
				<a class="nav-link text-light" href="javascript:loadPhp('clientes.php');">
				  <i class="nav-icon cui-briefcase"></i>Clientes
				</a>
			  </li>
			  <li class="nav-item ">
				<a class="nav-link text-light" href="javascript:loadPhp('usuarios.php');">
				  <i class="nav-icon cui-people"></i>Usuários
				</a>
			  </li>
				<li class="nav-item ">
				<a class="nav-link text-light" href="javascript:loadPhp('funcionarios.php');">
				  <i class="nav-icon cui-people"></i>Funcionários
				</a>
			  </li>
			</ul>
		  </li>
		  <li class="nav-item">
			<a class="nav-link nav-link-danger" href="logout.php?token=<?php echo md5(session_id());?>">
			  <i class="nav-icon cui-account-logout"></i>
			  <strong>SAIR</strong>
			</a>
		  </li>
		</ul>
	  </nav>
	  <button class="sidebar-minimizer brand-minimizer" type="button"></button>
	</div>

<!-- Seção 0000, PARTE CENTRAL DOS DISPLAY DOS DADOS - USAR AJAX PARA DAR NAVEGAR SEM SAIR DA CENTRAL -->
<main class="main" style="background-image:url('img/back.jpg'); background-repeat: no-repeat; background-attachment: fixed; background-position: top;">
	<div id="main">
			<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">Central</li>
		</ol>
	</nav>
	<div class="container-fluid">
		<div class="card">
			<div class='card-header'>
			<div class="row mt-1">
				<div class="col-7">
				<h3><cite>Sistema FireSystems</cite> - Calendário de Atividades:</h3>
					</div>
					<div class='col-5'>
						<h3 class='btn btn-outline-success float-right'>Administrador - <?php echo "Data Atual: ".date("d/m/Y", $_SERVER['REQUEST_TIME']);?></h3>
					</div>
				</div>
			</div> 
			<div class="card-body">	
			<div class='row'>
				<div class='col-7'>
					<h4><cite>Visão Geral por Pedidos:</cite></h4>
				</div>
				<div class='col-5'>
				<label for="formPedido">Detalhar Pedido:</label>
			<select class="form-control" id="formPedido" name="selectPedido">
			<option selected value=0>Visão Geral</option>
				<?php 	selectPedidos($conn);					?>
						</select>
				</div>
			</div>	
			</div>
					<div class="m-4" id="calendar"></div>
			</div>
		</div>
    </div>			
	
	</div>
</main>

<!-- Div body-app Encerramento -->
	</div>
	
	
	<footer class="app-footer">
		<div>
		<a href="http://www.firesystems-am.com.br">FireSystems-AM</a>
		<span>© 2018-2022 Produtos e Serviços Contra Incêndio </span>
		</div>
		<div class="ml-auto">
		<span>Sistemas de Gerenciamento Online</span>
		
		</div>
	</footer>
		<!-- fullCallendar ----------------------------------------------------->
		<script>
		$(document).ready(function() {

			$('#calendar').fullCalendar({

				aspectRatio: 1.8,
			  defaultDate: '<?php echo date('Y-m-d', $_SERVER['REQUEST_TIME']);?>',
			  editable: false,
			  eventLimit: true,
			  events:	<?php echo getEvents($conn);?>,
			  weekNumbers: true,
			  weekNumberTitle: 'W',
			  weekNumberCalculation: 'ISO'
			});

			});
		</script>
 </body> 
 
</html> 