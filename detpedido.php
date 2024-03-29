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
	
    require("./DB/conn.php");
    require("./controller/atividadesController.php");
    
    $cid = $_REQUEST["cid"];
    $pid = $_REQUEST["pid"];
    $pedido = getPedidoData($conn,$pid);
    $users = getUsers($conn);
	$cusers = getUsersCliente($conn,$cid);
	$medicoes = getMedicoes($conn,$pid);
	$alocacao = getAlocacao($conn,$pid);
	$acessoConvidado = getAcessoConvidado($conn,$pid);
	$usuarios = getUsuarios($conn);
	$acessoUsuario = getAcessoUsuario($conn,$pid);
	$funcionarios = getFuncionarios($conn);
	$listaCat = getListaCategorias($conn);

	function showUserAccess($nb_category_user){
		if($nb_category_user == 0) return 'Acesso Financeiro'; 
		if($nb_category_user == 1) return 'Somente Progresso'; 
	}

?>

	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="central.php">Central</a></li>
			<li class="breadcrumb-item active"><a href="javascript:loadPhp('clientes.php');">Cadastro de Clientes</a></li>
            <li class="breadcrumb-item active"><a href="javascript:loadCData('<?php echo $cid ?>');">Detalhes do Cliente</a></li>
			<li class="breadcrumb-item active">Detalhes do Pedido</li>
		</ol>
	</nav>
	<div class="container-fluid">
				<div class="card">
					<div class='card-header'><div class='row mt-1'><div class='col-8'>
						<h3><i class='nav-icon cui-list'></i> Dados do Pedido:</h3>
                        <h5><cite> <?php echo $pedido->tx_codigo;?></cite> - <?php echo $pedido->tx_nome;?></h5>
                        </div>
						<div class='col-4'>    
						<a class='btn btn-primary float-right' href="javascript:arqPedido('<?php echo $pid ?>');">
							<i class='nav-icon cui-paperclip'></i> Arquivos Técnicos do Pedido</a>	
						</div>
						</div>
					</div>	
					<div class="card-body">

    <form>	
  <div class='row'>
		<div class="form-group col-4">
			<label for="formCodigo">Código:</label>
			<input style="text-transform: uppercase;" type="text" required  minlength="4" class="form-control" id="formCodigo" value="<?php echo $pedido->tx_codigo;?>" name="Codigo">
		</div>
		<div class="form-group col-3">
			<label for="formiData">Início: </label>
			<input type="text" require class="form-control date" id="formiData" name="idata" value="<?php echo data_usql($pedido->dt_idata);?>" minlength="18" >
		</div>	
        <div class="form-group col-3">
			<label for="formtData">Término: </label>
			<input type="text" require class="form-control date" id="formtData" name="tdata" value="<?php echo  data_usql($pedido->dt_tdata);?>" minlength="18" >
		</div>	
        <div class="form-group col-2">
        <label for="formStatus">Status:</label>
			<select class="form-control" id="formStatus" name="Status">
            <?php 
                if($pedido->cs_estado == 0){
                    echo "<option selected value='0' class='text-success'>Ativo</option>
                          <option value='1' class='text-danger'>Encerrado</option>";
                }
                else{
                    echo "<option selected value='1' class='text-danger'>Encerrado</option>
                    <option value='0' class='text-success'>Ativo</option>";
                }
            ?>
			</select>
		</div>	
     </div>
     <div class='row'>
        <div class="form-group col-4">
			<label for="formLocal">Local: </label>
			<input type="text" require class="form-control" id="formLocal" name="Local" value="<?php echo $pedido->tx_local;?>">
		</div>	
        <div class="form-group col-3">
			<label for="formValor">Valor Total: </label>
			<input type="text" require class="form-control" id="formValor" name="Valor" value="<?php echo $pedido->nb_valor;?>">
		</div>	
        <div class="form-group col-2">
			<label for="formRetencao">Retenção: </label>
			<input type="text" require class="form-control" id="formRetencao" name="Retencao" value="<?php echo $pedido->nb_retencao;?>">
		</div>	
     </div>
     <div class='row'>
     <div class="form-group col-6">
        <label for="formCUser">Responsável no Cliente:</label>
			<select class="form-control" id="formCUser" name="Cuser">
            <?php 
            foreach($cusers as $cuser){
                if($cuser->id_usuario == $pedido->id_cliente_usr) echo "<option selected value=".$cuser->id_usuario.">".$cuser->tx_nome."</option>";
                else echo "<option value=".$cuser->id_usuario.">".$cuser->tx_nome."</option>";
            }
            ?>
			</select>
		</div>	
        <div class="form-group col-6">
        <label for="formUser">Responsável:</label>
			<select class="form-control" id="formUser" name="User">
            <?php 
            foreach($users as $user){
                if($user->id_usuario == $pedido->id_usu_resp) echo "<option selected value=".$user->id_usuario.">".$user->tx_name."</option>";
                else echo "<option value=".$user->id_usuario.">".$user->tx_name."</option>";
            }
            ?>
			</select>
		</div>	
     </div>
	<div class='row'>
		<div class="form-group col-12">
			<label for="formControlTextarea">Informações Relacionadas:</label>
			<textarea class="form-control" id="formControlTextarea" rows="3" name="pdDescricao"><?php echo $pedido->tx_descricao;?></textarea>
		</div>
	</div>
	<div class='row'>
		<div class="col-6">
			
		</div>
		<div class='col-3'>
		<button type='button' class='btn btn-danger float-left' data-toggle='modal' data-target='#modalRPedido'><i class='nav-icon cui-trash'></i> Remover Pedido</button>	
		</div>
		<div class='col-3'>
		<button type='button' class='btn btn-primary float-right' data-toggle='modal' data-target='#modalUPedido'><i class='nav-icon cui-pencil'></i> Atualizar Dados do Pedido</button>		
		</div>
	</div>
    </form>


	

<!------ LISTAGEM GERAL DAS MEDIÇÕES --------------------------------------->
  <div class="row m-auto">
 	<h4 class='col-6'><cite>Medições Cadastradas: </h4>
	<table class='table table-striped shadow rounded'>
		<thead>
			<tr>
				<th>Medição</th>
				<th>Data Entrada</th>
				<th>Status</th>
				<th>Situação</th>
				<th>Nota</th>
				<th>Emissão</th>
				<th>Vencimento</th>
				<th>Valor</th>
				<th>Revisar</th>
			</tr>
		</thead>
		<tbody>
<?php	

foreach($medicoes AS $medicao){
	$mid = $medicao->nb_ordem;
	// Aloca os medicaos e cria a list
	echo"<tr>

			<th class='text-center'>".$medicao->nb_ordem."</a></th>
			<th>".data_usql($medicao->dt_data)."</th>";
			if($medicao->cs_aprovada == 0) echo"<th class='text-warning'>Aprovação Pendente</th>";
			else echo"<th class='text-success'>Aprovada</th>";
			if($medicao->cs_finalizada == 0) echo"<th class='text-warning'>Aberta</th>";
			else echo"<th class='text-success'>Fechada</th>";
			if(is_null($medicao->tx_nota)) echo"<th class='text-warning'>Aguardando Nota</th>";
			else echo"<th>".$medicao->tx_nota."</th>";
			if(is_null($medicao->dt_emissao)) echo"<th class='text-warning'>Aguardando Nota</th>";
			else echo"<th>".data_usql($medicao->dt_emissao)."</th>";
			if(is_null($medicao->dt_vencimento)) echo"<th class='text-warning'>Aguardando Nota</th>";
			else echo"<th>".data_usql($medicao->dt_vencimento)."</th>";
			echo "<th> R$".moeda($medicao->v_medido)."</th>";
			if($medicao->cs_aprovada == 0) {echo "<th><button type='button' class='btn btn-warning mx-auto' id='revisarMedicao'
			data-local='1' data-id_medicao=$pedido->id_pedido value=$mid><i class='nav-icon cui-pencil'></i> Revisar Medição</button></th>";}
			else{
				echo "<th><button type='button' class='btn btn-warning mx-auto' id='revisarMedicao'
			disabled><i class='nav-icon cui-pencil'></i> Revisar Medição</button></th>";
			}
			echo "</tr>";	
	
	}	
?>
		</tbody>
	</table>
</div>   
<!------ LISTAGEM DAS ATIVIDADES --------------------------------------->			        
<div class='row m-auto'>  
	<h4 class='col-6'><cite>Atividades Cadastradas:</h4>
	<h4 class='col-6'>
		<button type='button' class='btn btn-primary mx-2 float-right' id='updateAllAtividade' value='1'><i class='nav-icon cui-pencil'></i> Salvar Atividades</button>
		<button type='button' class='btn btn-primary mx-2 float-right' data-toggle='modal' data-target='#modalGenerate'>&plus; Criar Atividades</button>
	</h4>
	<table class='table table-striped shadow rounded'>
		<thead>
			<tr>
				<th>Item-MD</th>
				<th class='col-4'>Atividade</th>
				<th class='col-2'>Categoria</th>
				<th>Status</th>
				<th>Quantidade</th>
				<th>Tipo</th>
				<th>Data Início</th>
				<th>Data Término</th>
				<th>Valor Total</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		
<?php
$categorias = getCategoriaPedido($conn,$pid);
$sumatv = 0.00;

foreach($categorias as $categoria){	
	echo"<tbody class='categoria-sub'>";
	$cid = $categoria->id_categoria;
	$atividades = getAtividades($conn,$pid,$cid);
	$sumcat = 0.00;
	foreach($atividades as $atividade){
	// Aloca os users e cria a list TOTALMENTE EDITÁVEL
	echo"<tr class='atividades'>
			<th><input type='text' require class='form-control' id='formAtvid_idx".$atividade->id_atividade."' name='Atvid_idx".$atividade->id_atividade."' value='".$atividade->id_idx."'></th>
			<th><input type='text' require class='form-control' id='formAtvtx_descricao".$atividade->id_atividade."' name='Atvtx_descricao".$atividade->id_atividade."' value='".$atividade->tx_descricao."'></th>
			<th><select require class='form-control' id='formAtvCat".$atividade->id_atividade."'>
				<option selected value='$cid'>".$categoria->tx_nome."</option>";
		foreach($listaCat as $catline){
				echo "<option value=".$catline->id_categoria.">".$catline->tx_nome."</option>";
			 }	
			echo"</select></th>";
			echo"<th><select require class='form-control' id='formAtvStatus".$atividade->id_atividade."'>";
			if($atividade->cs_finalizada == 0) echo"<option class='text-success' selected value='0'>Ativa</option><option class='text-danger' value='1'>Finalizar</option></select></th>";	
			else echo"<option class='text-danger' selected value='1'>Finalizada</option><option class='text-success' value='0'>Ativar</option></select></th>";
			echo "<th><input type='text' require class='form-control' id='formAtvnb_qtd".$atividade->id_atividade."' name='Atvnb_qtd".$atividade->id_atividade."' value='".$atividade->nb_qtd."'></th>
			<th><input type='text' require class='form-control' id='formAtvtx_tipo".$atividade->id_atividade."' name='Atvtx_tipo".$atividade->id_atividade."' value='".$atividade->tx_tipo."'></th>
			<th><input type='text' require class='form-control date' id='formAtvidata".$atividade->id_atividade."' name='Atvidata".$atividade->id_atividade."' value='".data_usql($atividade->dt_inicio)."'></th>
			<th><input type='text' require class='form-control date' id='formAtvfdata".$atividade->id_atividade."' name='Atvfdata".$atividade->id_atividade."' value='".data_usql($atividade->dt_fim)."'></th>
			<th><input type='text' require class='form-control valores' id='formAtvnb_valor".$atividade->id_atividade."' name='Atvnb_valor".$atividade->id_atividade."' value='".$atividade->nb_valor."'></th>
			<th><button type='button' class='btn btn-primary float-center button-update'  value='1' id='updateAtividade' data-id_atividade='".$atividade->id_atividade."' data-toggle='tooltip' data-placement='left' title='Salvar Atividade'><i class='nav-icon cui-pencil'></i></button></th>
			<th><button type='button' class='btn btn-danger float-center' data-toggle='modal' data-target='#modalExAtividade' value='".$atividade->id_atividade."' data-toggle='tooltip' data-placement='left' title='Excluir Atividade'><i class='nav-icon cui-trash'></i></button></th>
		</tr>";	
			$sumcat += $atividade->nb_valor;
		}
		echo "<tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th>Subtotal:</th><th><span id='subtotal'>R$ ".moeda($sumcat)."</span></th><th><th></th></tr>";
		echo"<tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>";
		$sumatv += $sumcat;
		echo "</tbody>";
	}	

	echo"<tbody><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th><th></th></th><th></th><th></th></tr>
	<tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th><h5>Total:</h5></th><th><h5><span id='totalfinal'>R$ ".moeda($sumatv)."</span></h5></th><th></th><th></th></tr></tbody>";


?>
		
	</table>
</div> 
</div>
</div>

<div class="card ">
	<div class='card-header'><div class='row'><div class='col-8'>
        <h5><cite>Controle de Acesso do Pedido</h5>
                        </div>
						<div class='col-4'>    
						
						</div>
						</div>
					</div>	
					<div class="card-body ">
					<div class="list-group list-group-accent shadow rounded">
<!------ LISTAGEM PARA CONTROLE ACESSO DE CONVIDADOS --------------------------------------->
<div class="list-group-item list-group-item-accent-primary">			
<div class="row col-12">
	
	<h4><cite>Convidados: </h4>
	<table class='table table-striped'>
		<thead>
			<tr>
				<th class='col-4'>Nome</th>
				<th class='col-2'>Nível de Acesso</th>
				<th class='col-2'>E-Mail</th>
				<th class='col-2'>Contato</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<?php
	 foreach($acessoConvidado as $convidado){
		echo "<tr>
		 			<th>".$convidado->tx_nome."</th>
					<th>".showUserAccess($convidado->nb_category_user)."</th> 
					<th>".$convidado->tx_email."</th>
					<th>".$convidado->tx_contato."</th>
					<th><button type='button' class='btn btn-danger float-right button-removeconvidado'  value='1'
					id='removerAcessoConvidado' data-id_pedido='".$pid."' data-id_cliente_usr='".$convidado->id_cliente_usr."'>
					<i class='nav-icon cui-user-unfollow'> Remover</button></th>
				</tr>";
	 }
?>				
		</tbody>
	</table>
</div>
<div class="row m-auto align-items-center">
	<h5 class="col-3"><cite>Liberar Acesso para Convidado:  </h5>
			<select class="form-control col-5" id="formAcessoConvidado" name="AcessoConvidado">
			<option selected hidden>Selecionar Convidado</option>
<?php	foreach($cusers as $cuser){
               echo "<option value=".$cuser->id_usuario.">".$cuser->tx_nome."</option>";
            }
?>	
		</select>
		<div class='col-2'>
		<button type='button' class='btn btn-primary float-right button-acessoconvidado' value="1"
		id="grantAcessoConvidado" data-id_pedido="<?php echo $pid;?>">
		<i class='nav-icon cui-user-follow'></i> Liberar Acesso</button>		
		</div>
	</div>   
</div>
<!------ LISTAGEM PARA CONTROLE ACESSO DE USUARIOS FIRE --------------------------------------->		
<div class="list-group-item list-group-item-accent-danger border-bottom border-top border-danger">	
<div class="row col-12">
	
	<h4><cite>Usuários FireSystems: </h4>
	<table class='table table-striped'>
		<thead>
			<tr>
				<th>Nome</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<?php
	 foreach($acessoUsuario as $usuario){
		echo "<tr>
		 			<th>".$usuario->tx_name."</th>					
					<th><button type='button' class='btn btn-danger float-right button-removeusuario'  value='1'
					id='removerAcessoUsuario' data-id_pedido='".$pid."' data-id_usuario='".$usuario->id_usuario."'>
					<i class='nav-icon cui-user-unfollow'> Remover</button></th>
				</tr>";
	 }
?>				
		</tbody>
	</table>
</div>
<div class="row m-auto align-items-center">
	<h5 class="col-3"><cite>Liberar Acesso para Usuário:  </h5>
			<select class="form-control col-5" id="formAcessoUsuario" name="AcessoUsuario">
			<option selected hidden>Selecionar Usuário</option>
<?php	foreach($usuarios as $user){
               echo "<option value=".$user->id_usuario.">".$user->tx_name."</option>";
            }
?>	
		</select>
		<div class='col-2'>
		<button type='button' class='btn btn-primary float-right button-acessousuario' value="1" 
		id="grantAcessoUsuario" data-id_pedido="<?php echo $pid;?>">
		<i class='nav-icon cui-user-follow'></i> Liberar Acesso</button>		
		</div>
	</div>   
	</div>   

<!------ LISTAGEM PARA ALOCAR FUNCIONÁRIOS --------------------------------------->			
<div class="list-group-item list-group-item-accent-dark ">
<div class="row col-12">

	<h4><cite>Colaboradores: </h4>
	<table class='table table-striped'>
		<thead>
			<tr>
				<th class='col-4'>Nome</th>
				<th class='col-4'>Função</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<?php
	 foreach($alocacao as $alocado){
		echo "<tr>
		 			<th>".$alocado->tx_nome."</th>
					<th>".$alocado->tx_funcao."</th>
					<th><button type='button' class='btn btn-danger float-right button-remover'  value='1' id='removerColaborador' data-id_pedido='".$pid."' data-id_funcionario='".$alocado->id_funcionario."'><i class='nav-icon cui-user-unfollow'> Remover</button></th>
				</tr>";
	 }
?>				
		</tbody>
	</table>

</div>
<div class="row m-auto align-items-center">
	<h5 class="col-3"><cite>Alocar Colaborador FireSystems:  </h5>
			<select class="form-control col-5" id="formColaborador" name="Colaborador">
			<option selected hidden>Selecionar Colaborador</option>
<?php	foreach($funcionarios as $colaborador){
               echo "<option value=".$colaborador->id_funcionario.">".$colaborador->tx_nome." - ".$colaborador->tx_funcao."</option>";
            }
?>	
		</select>
		<div class='col-2'>
		<button type='button' class='btn btn-primary float-right button-alocar' value="1" id="alocarColaborador" data-id_pedido="<?php echo $pid;?>"><i class='nav-icon cui-user-follow'></i> Alocar Colaborador</button>		
		</div>
	</div>
	</div>
	<div class="card-footer"><cite></cite></div>
	</div>
</div>
	

<!-- Page Closing ------------------------->
<div class='row'>
            <div id="process"></div>
            </div>
        </div>
        </div>
    </div>
<!-- Modal Remover Pedido ------------------------->
<div class="modal" style="text-align: left" id="modalRPedido" tabindex="-1" role="dialog" aria-labelledby="modalRPedido" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalRPedido">Remover Pedido <cite><?php echo$pedido->tx_codigo;?></cite></h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
	<h4>Deseja remover este pedido do sistema?</h4>
	<form>
		<input type="text" class="form-control" value="<?php echo$pedido->id_pedido;?>" id="Pid" hidden>
		<input type="text" class="form-control" value="<?php echo$pedido->id_cliente;?>" id="Cid" hidden>
	</form>
	<div class='row'>
		<div class='col-6'>
	
		</div>
		<div class='col-6'>
	<button type="button" class="btn btn-danger float-left" value="1" id="removeButton"><i class='nav-icon cui-trash'></i> Remover</button>
	<button type="button" class="btn btn-primary float-right" data-dismiss="modal"><i class='nav-icon cui-ban'></i> Cancelar</button>
		</div>
			</div>
			  </div>
			    <div class="modal-footer">
					<div id="process"></div>
				</div>
				
			  </div>
			</div>
		  </div>

		  <!-- Modal Autalizar Pedido ------------------------->
<div class="modal" style="text-align: left" id="modalUPedido" tabindex="-1" role="dialog" aria-labelledby="modalUPedido" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title" id="modalUPedido">Atualizar Pedido <cite><?php echo$pedido->tx_codigo;?></cite></h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
	<h4>Deseja atualizar os dados do pedido no sistema?</h4>
	<form>
		<input type="text" class="form-control" value="<?php echo$pedido->id_pedido;?>" id="Pid" hidden>
	</form>
	<div class='row'>
		<div class='col-6'>
	<button type="button" class="btn btn-primary float-right" value="1" id="updateButton"><i class='nav-icon cui-check'></i> OK</button>
		</div>
		<div class='col-6'>
	<button type="button" class="btn btn-danger float-right" data-dismiss="modal"><i class='nav-icon cui-ban'></i> Cancelar</button>
		</div>
			</div>
			  </div>
			    <div class="modal-footer">
					<div id="process"></div>
				</div>
				
			  </div>
			</div>
		  </div>
<!-- Modal GERAR multiplas atividades ------------------------->
		  <div class="modal" style="text-align: left" id="modalGenerate" tabindex="-1" role="dialog" aria-labelledby="modalGenerate" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title">Criar Múltiplas Atividades</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
	<h4>Selecione Categoria para criar as atividades: </h4>
	<form>
	<div class="form-group">
		<select class="form-control col-5" id="formCategoria">
		<option selected value="0" hidden>Selecionar Categoria</option>
<?php	foreach($listaCat as $catline){
               echo "<option value=".$catline->id_categoria.">".$catline->tx_nome."</option>";
            }
?>	
		</select>
		
		<label for="formMultiple">Número de Atividades: (máx.: 50)</label>
		<input type="text" class="form-control col-5" value="1" id="formMultiple"></input>
		<input type="text" class="form-control" value="<?php echo$pedido->id_pedido;?>" id="formPid" hidden>
		</div>

	</form>
	<div class='row'>
		<div class='col-6'>
	<button type="button" class="btn btn-primary float-right" value="1" id="generateButton"><i class='nav-icon cui-check'></i> Gerar Atividades</button>
		</div>
		<div class='col-6'>
	<button type="button" class="btn btn-danger float-right" data-dismiss="modal"><i class='nav-icon cui-ban'></i> Cancelar</button>
		</div>
			</div>
			  </div>
			    <div class="modal-footer">
					<div id="process"></div>
				</div>
				
			  </div>
			</div>
		  </div>
<!-- Modal Remover Pedido ------------------------->
<div class="modal" style="text-align: left" id="modalExAtividade" tabindex="-1" role="dialog" aria-labelledby="modalExAtividade" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title"><cite>Excluir Atividade:</cite></h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
	<h4>Deseja excluir esta atividade do sistema?</h4><br>
	<h5 id="nomeAtividade"></h5>
	<form>
		<input type="text" class="form-control" value="" id="id_atividade" hidden>
	</form>
	<div class='row'>
		<div class='col-6'>
	
		</div>
		<div class='col-6'>
	<button type="button" class="btn btn-danger float-left" value="1" id="excluirAtividade"><i class='nav-icon cui-trash'></i> Excluir</button>
	<button type="button" class="btn btn-primary float-right" data-dismiss="modal"><i class='nav-icon cui-ban'></i> Cancelar</button>
		</div>
			</div>
			  </div>
			    <div class="modal-footer">
					<div id="process"></div>
				</div>
				
			  </div>
			</div>
		  </div>