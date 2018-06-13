<!DOCTYPE html>
<html><head>
	<meta lang='pt-BR'>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="theme-color" content="#cccccc">
	<link rel="stylesheet" href="./dist/css/coreui.min.css">
	<style>
      .app-body {
        overflow-x: initial;
      }
    </style>
</head>
<body class="app header-fixed sidebar-md-show sidebar-fixed">
<header class='app-header navbar' style='background: #666; border-bottom: 3px solid #f11';>
	<button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
	<span class="navbar-toggler-icon"></span>
	</button>
		<a class="navbar-brand" style="align: center;" href="http://firesystems.com.br/">
		<img src="http://firesystems.com.br/images/logo.png" alt="FIRE Logo" width="150" height="50">
		</a>
			<ul class="nav navbar-nav">
				<li class="nav-item px-3">
				<a class="btn btn-warning" href="#">Site em Construção</a>
				</li>
			</ul>
</header>
<div class="app-body">	
	<div class="sidebar">
	  <nav class="sidebar-nav">
		<ul class="nav">
		  <li class="nav-title"><strong>FIRESYSTEMS LTD.</strong></li>
		  <li class="nav-item">
			<a class="nav-link" href="#">
			  <i class="nav-icon cui-speedometer"></i> Top
			</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="\empresa.php">
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
				<a class="nav-link" href="\pedido.php">
				  <i class="nav-icon cui-puzzle"></i>Situação Pedidos
				</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="#">
				  <i class="nav-icon cui-puzzle"></i>Controle Produção
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

<!-- PARTE CENTRAL DOS DISPLAY DOS DADOS  -->

<main class='main'>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="\central.php">Central</a></li>
			<li class="breadcrumb-item active">Pedidos por Cliente</li>
		</ol>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 ">
				<div class="card">
					<div class="card-body">
						<h2>Situação dos Pedidos por Cliente</h2>
<?php
 
$servername = "mysql.firesystems.com.br";
$username = "firesystems";
$password = "fire2014";

// Create connection must be utf-8 to work

$conn = new PDO("mysql:host=mysql.firesystems.com.br;dbname=firesystems;charset=utf8", "firesystems", "fire2014");


//Carrrga as empresas pra colocar no titulo dos cards
$stmt0 = $conn->query("SELECT id_cliente,tx_nome,tx_cnpj FROM cliente ORDER BY tx_nome ASC");

while($row0 = $stmt0->fetch(PDO::FETCH_OBJ)){
	$cliente = $row0->id_cliente;
	$cnpj = substr($row0->tx_cnpj, 0, 2) . "." .substr($row0->tx_cnpj, 2, 3) .".".substr($row0->tx_cnpj, 5, 3)."/".substr($row0->tx_cnpj, 8, 4)."-".substr($row0->tx_cnpj, 12, 2);
	$id=$row0->id_cliente;	
	echo"<div class='bd-example'>
	<div class='accordion' id='accordion'>
		<div class='card'>
		<div class='card-header' id='heading".$id."'>
			<h5 class='mb-0'>
				<button class='btn btn-outline-danger' type='button' data-toggle='collapse' data-target='#collapse".$id."' aria-expanded='true' aria-controls='collapse".$id."'>";					
	echo $row0->tx_nome." - CNPJ: ".$cnpj;
	echo"</button>
			</h5>
				</div>
					<div id='collapse".$id."' class='collapse' aria-labelledby='heading".$id."' data-parent='#accordion'><div class='card-body'>";
	
		
	// Carrega os pedidos e coloca nos cards
	$stmt = $conn->query("SELECT c.id_cliente, p.tx_codigo, p.cs_estado, v.medido_total, v.nb_valor FROM cliente As c 
							INNER JOIN pedido AS p ON c.id_cliente = p.id_cliente
							INNER JOIN v_sum_pedido_total AS v ON p.id_pedido = v.id_pedido
							WHERE c.id_cliente = " . $cliente . " ORDER BY p.tx_codigo ASC;");

	if($stmt == NULL){
		echo"<p> Não Tem NADA. !! </p>";}
	else{
			  

		while($row = $stmt->fetch(PDO::FETCH_OBJ)){
			
			echo "<div class='progress-group'>";
			  if($row->cs_estado == 0) 
					echo "<div class='progress-group-header align-items-end' style='color: #27b;'><div><a class='btn btn-ghost-primary' href='http://www.firesystems.com.br/' role='button'><strong>Pedido: " . $row->tx_codigo . " (Ativo)</strong></a></div>";
			  if($row->cs_estado == 1) 
					echo "<div class='progress-group-header align-items-end' style='color: #777;'><div><a class='btn btn-ghost-secondary' href='http://www.firesystems.com.br/' role='button'><strong>Pedido: " . $row->tx_codigo . " (Encerrado)</strong></a></div>";
			  $percent = $row->medido_total / $row->nb_valor;
			  $percent = $percent * 100;
			  echo "<div class='ml-auto'>Progresso: (" . round($percent) ."%) - ";
			  echo " R$" . (int)$row->medido_total . " / " . $row->nb_valor . "</div></div>";
			  echo "<div class='progress-group-bars'> <div class='progress progress-xs'>";
			  echo "<div class='progress-bar progress-bar-stripped bg-success' role='progressbar' style='width: ".round($percent)."%' aria-valuenow='".round($percent)."' aria-valuemin='0' aria-valuemax='100'></div></div></div></div>";
		}
	}
	echo"</div></div></div></div></div>";
}
?>
</div>
<br>	


		
	</main>
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
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="./assets/js/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	
 
		<script src="./assets/js/vendor/popper.min.js"></script>
		<script src="./dist/js/bootstrap.js"></script>
		<script src="./assets/js/perfect-scrollbar.min.js"></script>
		<script src="./assets/js/coreui.min.js"></script>
		<script src="./assets/js/docs.min.js"></script>
 </body> 
</html> 