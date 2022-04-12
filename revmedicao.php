<style>
      .btn {
        white-space: normal;
      }
</style>
<?php
session_start(); 

require("./controller/agentController.php");
Auth::accessControl($_SESSION['catuser'],0);
require("./DB/conn.php");
require("./controller/atividadesController.php");

$pid = $_REQUEST["pid"];
$mid = $_REQUEST["mid"];
$controlid = $_REQUEST["controlid"];

$balance = array();
$measure = 0.00;
$pedido = getPedidoData($conn, $pid);
$users = getAcessoConvidado($conn,$pid);
$categorias = getCategoriaAtividades($conn,$pid,$mid);
$medidas = getMedicaoResume($conn,$pid,$mid);
$cid = $pedido->id_cliente;

?>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="central.php">Central</a></li>
			<li class="breadcrumb-item "><a href="javascript:loadPhp('pedidos.php');">Pedidos por Cliente</a></li>
			<li class='breadcrumb-item '><a href='javascript:<?php if($controlid) echo "loadPData($pid,$cid)"; else echo "atvPhp($pid)";?>;'>Detalhes do Pedido</a></li>
			<li class="breadcrumb-item active">Revisar Medição</li>
		</ol>
	</nav>
	<div class="container-fluid">
		<div class="card">
		<div class='card-header'><div class="row mt-1"><div class="col-9">
		 
			<h3><i class='nav-icon cui-pencil'></i> Revisar Medição 
									
<?php

echo $mid." do Pedido : ".$pedido->tx_codigo." - <cite>".$pedido->tx_nome."</cite></h3>
							</div>
							<div class='col-3'>
								
							</div>
						</div>
					</div> 	
		<div class='card-body border border-warning rounded-top'>
		<nav id='navbar-atividades' class='navbar navbar-light bg-light'>
		<ul class='nav nav-pills'>";
		foreach($categorias AS $cat){
		echo" <li class='nav-item'>
			<a class='nav-link' href='#".$cat->tx_nome."'>".$cat->tx_nome."</a>
		  </li>";
		}
		echo"</ul>
	 	 </nav>
		
		 <div data-spy='scroll' data-target='#navbar-atividades' data-offset='0'>";
			//LOOP START
	foreach($categorias AS $cat){
		echo"<h5 id='".$cat->tx_nome."'>".$cat->tx_nome."</h5>";
	foreach($medidas as $line){
		if($cat->id_categoria == $line->id_categoria){
		$aid = $line->id_atividade;
		$measure += $line->nb_valor;
		$limit = $line->nb_sum - $line->nb_valor ;
		$percent = ($line->nb_valor / $line->nb_sum) * 100;
		$percent = number_format($percent,2,'.','');
		echo "<div class='input-group py-2 border-bottom border-primary'>
				<label class='col-12' for='formMAtiv'>
				<i class='nav-icon cui-chevron-right'></i> ".$line->tx_descricao."<cite> (".$line->tx_nome.") </cite></label>
				<div class='input-group-prepend'>
						<span class='input-group-text'>R$</span>
					</div>
				<input type='text' class='form-control col-4 parcela' id='formMAtiv' value='".number_format($line->nb_valor,2,'.','')."' 
				data-aid='$aid' data-nb_sum='$line->nb_sum' data-nb_valor='$line->nb_valor' data-id_pedido='$pid' data-nb_ordem='$mid' data-limit='$limit' name='nbVal[$aid]'></input>
				<div class='col-6 py-2'>
				<cite ><span id='percent$aid'>$percent</span>% da Atividade.</cite>
				- Saldo: <span id='limit$aid'>R$ ".moeda($limit)."</span></cite>
				<input type='text' class='form-control' id='formMAtiv' value='$aid' name='idAtiv[$aid]' hidden></input>
				</div>
			</div>";
			}
			}
			$p_percent = ($measure / $pedido->nb_valor)*100;
			$p_percent = number_format($p_percent,2,'.','');

			$sbalance = $pedido->medido_total - $measure;
	}?>
		<input type="text" class="form-control" id="pedidoValor" value="<?php echo $pedido->nb_valor;?>" hidden> 
		<input type="text" class="form-control" id="medidoSaldo" value="<?php echo $sbalance;?>" hidden>
	<?php
		echo"</div> 
			<table class='table table-striped'>
					<thead>
						<tr>
							<th>Avanço Original</th>
							<th>Novo Avanço</th>
							<th>Valor Original</th>
							<th>Novo Valor</th>
							<th>Saldo Pedido</th>
							
						</tr>
					</thead>
					<tbody>
				<tr>
							<th>".$p_percent." %</th>
							<th><strong><span id='resultado'>".moeda($line->percent)." %</span></strong></th>
							<th>R$ ".moeda($measure)."</th>
							<th><strong><span id='soma'> R$".moeda($measure)."</span></strong></th>
							<th><span id='saldo'>R$ ".moeda(($pedido->nb_valor - $measure))."</span></th>
							

						</tr>";
			echo"</tbody>
					</table>	
					</div>
				  	
					<div class='card-footer'>
					<button type='button' class='btn btn-primary float-left' id='updateMedicao' value='1' data-controlid=$controlid><i class='nav-icon cui-pencil'></i> Salvar Valores</button>";
			if(!$controlid) echo"<a role='button' class='btn btn-secondary float-right' href='javascript:atvPhp($pid);'><i class='nav-icon cui-action-undo'></i> Voltar</a>";
			else echo"<a role='button' class='btn btn-secondary float-right' href='javascript:loadPData($pid,$cid);'><i class='nav-icon cui-action-undo'></i> Voltar</a>";
			echo"</div>
			  </div>
			</div>";
		
		
?>
</div></div>