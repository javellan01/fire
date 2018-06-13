<!DOCTYPE html>
<html><head>
	<meta lang='pt-BR'>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>FireSystems.online</title>
	<link rel="stylesheet" href="./dist/css/coreui.min.css">
	<style>
      .app-body {
        overflow-x: initial;
      }
    </style>
		<script src="./assets/js/jquery-3.3.1.min.js"></script>
		<script src="./assets/js/jquery-ui.min.js"></script>
		<script src="./assets/js/jquery.ajax.form.js"></script>
		<script src="./assets/js/jquery.mask.min.js"></script>
		<script src="./assets/js/popper.min.js"></script>
		<script src="./dist/js/bootstrap.js"></script>
		<script src="./assets/js/perfect-scrollbar.min.js"></script>
		<script src="./assets/js/coreui.min.js"></script>
		<script src="./assets/js/docs.min.js"></script>
	<!-- AJAX Scriping for loading dynamically PHP on server -->
	<script>
		function loadPhp(str) {
			var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
			document.getElementById("main").innerHTML = this.responseText;
			}
		};
		xhttp.open("GET", str, true);
		xhttp.send();
		}
		function atvPhp(str) {
			var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
			document.getElementById("main").innerHTML = this.responseText;
			}
			};
			xhttp.open("GET", "atividades.php?pid="+str, true);
			xhttp.send();
			}
		function loadBar(str) {
			var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
			document.getElementById("bar").innerHTML = this.responseText;
			}
			};
			xhttp.open("GET", "progress.php?"+str, true);
			xhttp.send();
			}	
		function formProc() {
			var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
			document.getElementById("process").innerHTML = this.responseText;
			}
			};
			var formData = $('form').serialize();
			xhttp.open("GET", "process.php?"+formData, true);
			xhttp.send();
			}	
	</script>
	<script>
		$(document).ready(function(){ 
		  $('#formCNPJ').mask('00.000.000/0000-00', {reverse: true});
		  });
	</script>
	<!-- autocomplete Javascript -->
	<script type="text/javascript">
		$(function() {
			var availableTags = ["REVIS\u00c3O DO PROJETO EXECUTIVO","ELABORA\u00c7\u00c3O DO PROJETO DE FABRICA\u00c7\u00c3O","ISOMETRIA DO SISTEMA","INTEGRA\u00c7\u00c3O","MOBILIZA\u00c7\u00c3O","CONTAINER DEP\u00d3SITO\/ESCRIT\u00d3RIO","ANDAIMES","FRETES","PIPESHOP - EL\u00c9TRICA","PIPESHOP - HIDRAULICA","PIPESHOP - FERRAMENTARIA","PREPARA\u00c7\u00c3O DOS SUPORTES","PREPARA\u00c7\u00c3O E PINTURA","PREPARA\u00c7\u00c3O DOS SUPORTES","PR\u00c9 FABRICA\u00c7\u00c3O - SPOOL \u00d81","FABRICA\u00c7\u00c3O DOS SUPORTES","INSTALA\u00c7\u00c3O DOS SUPORTES","INSTALA\u00c7\u00c3O DOS RAMAIS (SPOOL)","INSTALA\u00c7\u00c3O DAS DESCIDAS","INSTALA\u00c7\u00c3O TUBUL\u00c7\u00c3O","INSTALA\u00c7\u00c3O DOS HIDRANTES","INSTALA\u00c7\u00c3O DA INFRA SECA","PASSAGEM DE FIOS & CABOS","INSTALA\u00c7\u00c3O DOS SUPORTES","INSTALA\u00c7\u00c3O SPOOL","INSTALA\u00c7\u00c3O DOS SPOOL (1.1\/2 \u00e0 2\")","MANIFOLD 10\" COM 02 SA\u00cdDAS (8\" e 4\")","CONEX\u00c3O DE DRENO","CONEX\u00c3O DE TESTE","INSTALA\u00c7\u00c3O DOS SPRINKLERS","INSTALA\u00c7\u00c3O - FSP-851","INSTALA\u00c7\u00c3O - FST-851R","INSTALA\u00c7\u00c3O - P2R-PG","INSTALA\u00c7\u00c3O - FCM-1","INSTALA\u00c7\u00c3O - FMM-1","INSTALA\u00c7\u00c3O - FCPS-24S8","ALARME - PROGRAMA\u00c7\u00c3O E START-UP"];
			$("#formAtividade").autocomplete({
				source: availableTags,
				autoFocus:true
			});
		});
	</script>
</head>
<body class="app header-fixed sidebar-md-show sidebar-fixed">
<header class='app-header navbar' style='background: #2f353a; border-bottom: 4px solid #a60117;'>
	<button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
	<span class="navbar-toggler-icon"></span>
	</button>
		<a class="navbar-brand" href="http://firesystems.com.br/">
		<img src="http://firesystems.com.br/images/logo.png" alt="FIRE Logo" width="150" height="50">
		</a>
			<ul class="nav navbar-nav">
				<li class="nav-item px-3">
				<a class="btn btn-light href="#">Logout</a>
				</li>
			</ul>
</header>
<div class="app-body">	
	<div class="sidebar">
	  <nav class="sidebar-nav">
		<ul class="nav">
		  <li class="nav-title"><strong>FIRESYSTEMS.online</strong></li>
		  <li class="nav-item">
			<a class="nav-link" href="#">
			  <i class="nav-icon cui-speedometer"></i> Top
			</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href=".\empresa.php">
			  <i class="nav-icon cui-speedometer"></i> Old page
			  <span class="badge badge-primary">OLD</span>
			</a>
		  </li>
		  <li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#">
			  <i class="nav-icon cui-puzzle"></i> Sistema
			</a>
			<ul class="nav-dropdown-items">
				<li class="nav-item">
				<a class="nav-link" href="javascript:loadPhp('central.php');">
				  <i class="nav-icon cui-puzzle"></i>Central
				</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="javascript:loadPhp('pedidos.php');">
				  <i class="nav-icon cui-puzzle"></i>Situação Pedidos
				</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="javascript:loadPhp('modal.php');">
				  <i class="nav-icon cui-puzzle"></i>Modal
				</a>
			  </li>
			  
			</ul>
		  </li>
		  <li class="nav-item">
			<a class="nav-link nav-link-danger" href="about:blank">
			  <i class="nav-icon cui-layers"></i>
			  <strong>SAIR</strong>
			</a>
		  </li>
		</ul>
	  </nav>
	  <button class="sidebar-minimizer brand-minimizer" type="button"></button>
	</div>

<!-- Seção 0000, PARTE CENTRAL DOS DISPLAY DOS DADOS - USAR AJAX PARA DAR NAVEGAR SEM SAIR DA CENTRAL -->
<main class="main">
	<div id="main">
	
	</div>
</main>

<!-- Div body-app Encerramento -->
	</div>
	
	
	<footer class="app-footer">
		<div>
		<a href="http://www.firesystems.com.br">FireSystems</a>
		<span>© 2018 Sistemas de Proteção Contra Incêncido LTDA.</span>
		</div>
		<div class="ml-auto">
		<span>Powered by</span>
		<a href="http://www.javellan.16mb.com">JAVELLAN</a>
		</div>
	</footer>
		<!-- jQuery (necessary for Boot strap's JavaScript plugins) -->
		
 </body> 
</html> 