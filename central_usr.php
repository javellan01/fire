<?php 
	// Inicia sessões
	session_start(); 
	//echo session_status(); 
	// Verifica se existe os dados da sessão de login 
	if(!isset($_SESSION["login"]) && !isset($_SESSION["usuario"])) 
		{ 
	// Usuário não logado! Redireciona para a página de login 
		header("Location: login.php"); 
		exit; 
	} 

	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: 0"); //

	
	require("./controller/agentController.php");
	require("./controller/eventsController.php");
	Auth::accessControl($_SESSION['catuser'],2);
	require("./DB/conn.php");

?>
<!DOCTYPE html>
<html><head>
	<meta lang='pt-BR'>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Central | FireSystems.online</title>
	<link rel="stylesheet" href="./assets/css/toastr.min.css">
	<link rel="stylesheet" href="./dist/css/coreui.min.css">
	<link rel="stylesheet" href="./dist/css/coreui-icons.min.css">
	<link rel="stylesheet" href="./dist/css/fullcalendar.min.css">
	<link rel="stylesheet" href="./assets/css/jquery-ui.css">
	<style>
      .app-body {
        overflow-x: initial;
      }
	  .fc-sat {background-color: #eee;}
	  .fc-sun {background-color: #eee;}
	  .fc-week-number {background-color: #09568d; color: white;}
	  .fc-day-top {color: #09568d;}
	  .fc-day-header {color: #09568d;}
    </style>
		<script src="./assets/js/jquery-3.6.0.min.js"></script>
		<script src="./assets/js/jquery-ui.min.js"></script>
		<script src="./assets/js/jquery.ajax.form.js"></script>
		<script src="./assets/js/jquery.mask.min.js"></script>
		<script src="./assets/js/popper.min.js"></script>
		<script src="./dist/js/bootstrap.js"></script>
		<script src="./assets/js/perfect-scrollbar.min.js"></script>
		<script src="./assets/js/coreui.min.js"></script>
		<script src="./assets/js/docs.min.js"></script>
		<script src="./assets/js/vue.min.js"></script>
		<script src="./assets/js/toastr.min.js"></script>
	<!-- AJAX Scriping for loading dynamically PHP on server -->
		
		<script src="./assets/js/moment.min.js"></script>
		<script src="./dist/js/fullcalendar.min.js"></script>
		<script src="./dist/js/locale/pt-br.js"></script>
		<script src="./assets/js/central.js"></script>
		<script>
		$(document).ready(function() {

			$('#calendar').fullCalendar({
			  defaultView: 'basicWeek',	
			  aspectRatio: 4,
			  defaultDate: '<?php echo date("Y-m-d", $_SERVER['REQUEST_TIME']);?>',
			  eventRender: function(eventObj, $el) {
				  $el.popover({
					title: eventObj.title+', Pedido: '+eventObj.pedido,
					content: eventObj.periodo,
					trigger: 'hover',
					placement: 'top',
					container: 'body'
				});
			  },
			  
			  editable: false,
			  eventLimit: true,
			  events: 	<?php fillUCalendar($conn,5);?>,
			  
			  weekNumbers: true,
			  weekNumberTitle: 'W',
			  weekNumberCalculation: 'ISO'
			});

			});
		</script>
</head>
<?php

	

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
				<a class="nav-link text-light" style="font-weight: 500;" href="javascript:loadPhp('perfil.php');"><i class="nav-icon cui-info"></i><?php echo " ".$_SESSION['usuario'];?></a>
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
		  <li class="nav-title" id="fecharBtn"><strong>FIRESYSTEMS.online</strong></li>
		  <li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#">
			  <strong><i class="nav-icon cui-layers"></i> Sistema BASE </strong>
			  
			</a>
			<ul class="nav-dropdown-items">
				<li class="nav-item">
				<a class="nav-link" href="central_usr.php">
				  <i class="nav-icon cui-home"></i>Central
				</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="javascript:loadPhp('pedidos_usr.php');">
				  <i class="nav-icon cui-list"></i>Pedidos
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
<main class="main" style="background-image:url('img/_f_back.jpg'); background-repeat: no-repeat; background-attachment: fixed; background-position: top;">
	<div id="main">
			<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">Central</li>
		</ol>
	</nav>
	<div class="container-fluid">
		<div class="card">
			<div class='card-header'>
			<div class="row mt-4">
				<div class="col-7">
				<h3>Sistema FireSystems.online:</h3>
					</div>
					<div class='col-5'>
						<h3 class='btn btn-outline-dark float-right'>Base - <?php echo "Data Atual: ".date("d/m/Y", $_SERVER['REQUEST_TIME']);?></h3>
					</div>
				</div>
			</div> 	
			
			<div class="card-body">
				<div class='row'>
					<div class='col-6'>
					<a class='btn btn-outline-dark' href="javascript:loadPhp('pedidos_usr.php');" role='button'><strong><i class='nav-icon cui-note'></i> Situação dos Pedidos</strong></a>	
					</div>
				</div>	
				<div class='row'>
				<div class="card-body"><h4><cite>Visão Geral:</cite></h4>
					<div class="m-4" id="calendar">	</div>
				</div>
				</div>
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
		<!-- jQuery (necessary for Boot strap's JavaScript plugins) -->
		
 </body> 
</html> 