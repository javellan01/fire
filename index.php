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
		function require(file,callback){
            var head=document.getElementsByTagName("head")[0];
            var script=document.createElement('script');
            script.src=file;
            script.type='text/javascript';
            //real browsers
            script.onload=callback;
            //Internet explorer
            script.onreadystatechange = function() {
                if (_this.readyState == 'complete') {
                    callback();
                }
            }
            head.appendChild(script);
        }
		function loadPhp(str) {
			var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
			document.getElementById("main").innerHTML = this.responseText;
			
			$('#formCNPJ').mask('00.000.000/0000-00', {reverse: false});
			$('#formCPF').mask('000.000.000-00', {reverse: false});
			$('#formTel').mask('(00) #0000-0000', {reverse: false});
			
			$('#modalPedido').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget);
			  var cliente = button.data('cliente');
			  var id_cliente = button.data('id_cliente');
			  var modal = $(this);
			  modal.find('#formSCliente.form-control').val(cliente);
			  modal.find('#formidCliente.form-control').val(id_cliente);
			});
			
			}		
				
			
			};
		
		xhttp.open("GET", str+"?ts="+Date.now(), true);
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
		function atv_uPhp(str) {
			var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
			document.getElementById("main").innerHTML = this.responseText;
			
			$('#modalCenter').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget);
			  var atividade = button.data('atividade');
			  var id_atividade = button.data('id_atividade');
			  var modal = $(this);
			  modal.find('.modal-title').text(atividade);
			  modal.find('#Qtdin').val(id_atividade);
			});
			function myFunction() {
				document.getElementById("process").innerHTML = "Paragraph changed.";
			}
				}
			};
			xhttp.open("GET", "atividades_usr.php?pid="+str, true);
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
		$("#fecharBtn").click(function(){
			$("#main").load("pedidos.php #pedidoAccord");
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
		  <li class="nav-title" id="fecharBtn"><strong>FIRESYSTEMS.online</strong></li>
		  <li class="nav-item">
			<a class="nav-link" href="#">
			  <i class="nav-icon cui-speedometer"></i> Top
			</a>
		  </li>
		  <li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#">
			  <i class="nav-icon cui-puzzle"></i> Sistema
			  <span class="badge badge-danger">ADMIN</span>
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
				<a class="nav-link" href="javascript:loadPhp('usuarios.php');">
				  <i class="nav-icon cui-puzzle"></i>Usuários
				</a>
			  </li>
			  
			</ul>
		  </li>
		  <li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#">
			  <i class="nav-icon cui-puzzle"></i> Sistema
			  <span class="badge badge-light">BASE</span>
			</a>
			<ul class="nav-dropdown-items">
				<li class="nav-item">
				<a class="nav-link" href="javascript:loadPhp('central_usr.php');">
				  <i class="nav-icon cui-puzzle"></i>Central
				</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="javascript:loadPhp('pedidos_usr.php');">
				  <i class="nav-icon cui-puzzle"></i>Pedidos
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