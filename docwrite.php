<?php
require("./DB/conn.php");
require("./plugin/xlsxwriter.class.php");

$result = $result0 = $result1 = $result2 = $result3 = $dt_resumo = $e = '';
$data = array();

if(isset($_POST['pid']) && $_POST['pid'] != ''){
		$pid = $_POST['pid'];
		$cid = '';
		$sheet='Medições ' . $dt_resumo;
		$styles1 = array( 'font-size'=>12,'font-style'=>'bold');
		$styles3 = array( [],['halign'=>'right'],[],[]);
		
		//Carrega dados do pedido e nome cliente
		$result = $conn->query("SELECT p.*, c.tx_nome FROM pedido p INNER JOIN cliente c ON p.id_cliente = c.id_cliente WHERE p.id_pedido = $pid");
		$valor_pedido = $row->nb_valor;

		// Carrega as somas result das medições e sabemos quantas medições temos
		$result1 = $conn->query("SELECT SUM(am.nb_valor) v_medido, m.* FROM atividade_medida am 
			LEFT JOIN medicao m ON am.id_pedido=m.id_pedido AND am.nb_ordem = m.nb_ordem 
			WHERE m.id_pedido = $pid GROUP BY m.nb_ordem ASC;");
		$valor_medido[$row1->nb_ordem] = $row1->v_medido;
		$percent_medido[$row1->nb_ordem] = round(($row1->v_medido / $valor_pedido),1);
		// Carrega as categorias
		$result2 = $conn->query("SELECT c.* FROM atividade a  
		INNER JOIN categoria c ON a.id_categoria=c.id_categoria
		WHERE a.id_pedido = $pid GROUP BY a.id_categoria ASC");
		$cid = $row2->id_categoria;
		
		// "NÃO SERVE NA PLANILHA"  -- Carrega as Somas result das categorias Gera progresso da categoria 
		//$result3 = $conn->query("SELECT id_categoria, SUM(nb_valor) nbvalor, SUM(valor_sum) valorsum, SUM(qtd_sum) qtdsum, SUM(nb_qtd) nbqtd, CAST(SUM(progresso) //AS DECIMAL(10,2)) progresso, v_unit FROM v_categoria_sums WHERE id_pedido = $pid AND id_categoria = $cid GROUP BY id_categoria");
		
		//Carrega as atividades e todos os dados para comparativos
		$result3 = $conn->query("SELECT a.*, v1.qtd_sum, v1.progresso, v1.nb_valor, v1.valor_sum FROM atividade a 
		LEFT JOIN v_categoria_sums v1 ON a.id_atividade=v1.id_atividade 
		WHERE a.id_pedido = $pid AND a.id_categoria = $cid");
		
		while($row = $result3->fetch(PDO::FETCH_OBJ)){
		if($row->valor_sum == null) $row->valor_sum = 0;
		$execpercent = ($row->progresso / $row->nb_valor) * 100;
		$execpercent = round($execpercent,1);
		
		$medpercent = ($row->valor_sum / $row->nb_valor) * 100;
		$medpercent = round($medpercent,1);	
	
		$balpercent = $execpercent - $medpercent;
		
		if($balpercent < 0) $balpercent = 0;
		if($balpercent > 100) $balpercent = 100;
		$balance[$row->id_atividade] = round(($row->progresso - $row->valor_sum),2);
		if($balance[$row->id_atividade] < 0) $balance[$row->id_atividade] = 0;	
		if($balance[$row->id_atividade] > $row->nb_valor) $balance[$row->id_atividade] = $row->nb_valor;
		
		
		$n_proj = $result0->rowCount()." Projetos";
		$writer = new XLSXWriter();
		//Write XLS MetaData
		$writer->setTitle('Medição');
		$writer->setSubject('Controle Faturamento');
		$writer->setAuthor('FireSystemsOnline');
		$writer->setCompany('FireSystems LTD.');
		//Write Cabeçalho
  		$writer->writeSheetHeader($sheet, array('Item' => 'string',
												'Descrição' => 'string',
												'Qtd.' => 'integer',
												'Tipo' => 'string',
												'Materiais' => '[$R$-1009] #,##0.00',
												'Serviços' => '[$R$-1009] #,##0.00',
												'Total' => '[$R$-1009] #,##0.00'),
												$col_options = array('widths'=>[10,72,13,20] ));
	 	//$writer->markMergedCell($sheet, $start_row=1, $start_col=0, $end_row=1, $end_col=1);
		//Linha Principal
		$writer->writeSheetRow($sheet, array('Resumo de Horas e Despesas por Projeto: ('.$n_proj.') - Periodo: '.$dt_resumo), $styles1 );
		$writer->writeSheetRow($sheet, array('','','',''));
	
		
		
		//GERA linha nome do projeto
		while($row0 = $result0->fetch(PDO::FETCH_OBJ)){
			$pid = $row0->id_projeto;
			$styles2 = array( 'font-size'=>11,'font-style'=>'bold', 'color'=> $row0->tx_color);
			$writer->writeSheetRow($sheet, array($row0->id_projeto,$row0->tx_projeto,$row0->total_horas,$row0->total_despesas), $styles2 );
			
		
		
		//Preenche os funcionarios relacionados ao projeto
		$result=$conn->query("SELECT v.nb_horas as horas, v.nb_despesas as despesas, u.tx_name FROM v_resumo_mensal v INNER JOIN users u ON id_funcionario = id_usuario WHERE dt_resumo LIKE '".$dt_resumo."' AND v.id_projeto = ".$pid." ORDER BY u.tx_name ASC");
		while($row = $result->fetch(PDO::FETCH_OBJ)){
			
			$writer->writeSheetRow($sheet, array('',$row->tx_name,$row->horas,$row->despesas) ,$styles3 );
			
			}	
		
		}
		$result = $result0 = '';
		// Gera a pasta dos colaboradores	
		$styles2 = $styles3 = '';
		$sheet2='Colaboradores '.$dt_resumo;
		$writer->writeSheetHeader($sheet2, array('Função' => 'string',
												'Nome' => 'string',
												'Horas' => 'integer',
												'Despesas' => '[$R$-1009] #,##0.00'
												), $col_options = array('widths'=>[18,72,13,20] ));
		$writer->markMergedCell($sheet2, $start_row=1, $start_col=0, $end_row=1, $end_col=1);
		//Chamda DB do funcionario
		$result0=$conn->query("SELECT v.id_funcionario, u.tx_funcao, u.tx_name, SUM(v.nb_horas) as total_horas, SUM(v.nb_despesas) as total_despesas FROM v_resumo_mensal v INNER JOIN users u ON v.id_funcionario = u.id_usuario WHERE dt_resumo LIKE '".$dt_resumo."' GROUP BY v.id_funcionario");
		//Linha Principal
		$writer->writeSheetRow($sheet2, array('Resumo de Horas e Despesas por Colaborador: 		Periodo: '.$dt_resumo), $styles1 );
		$writer->writeSheetRow($sheet2, array('','','',''));
	
		
		$color = 0;
		//GERA linha nome do colaborador
		while($row0 = $result0->fetch(PDO::FETCH_OBJ)){ 
			
			$uid = $row0->id_funcionario;
			if(fmod($color,2) == 0){
				$styles2 = array( 'font-size'=>11,'font-style'=>'bold', 'color'=> '#000000');
				}
				else {
				$styles2 = array( 'font-size'=>11,'font-style'=>'bold', 'color'=> '#555555');
				}
			
			$writer->writeSheetRow($sheet2, array($row0->tx_funcao,$row0->tx_name,$row0->total_horas,$row0->total_despesas), $styles2 );
			
		//Preenche os funcionarios relacionados ao projeto
		$result=$conn->query("SELECT v.tx_color, v.id_projeto, v.tx_projeto, v.nb_horas as horas, v.nb_despesas as despesas FROM v_resumo_mensal v WHERE dt_resumo LIKE '".$dt_resumo."' AND v.id_funcionario = ".$uid." ORDER BY v.id_projeto ASC");
		while($row = $result->fetch(PDO::FETCH_OBJ)){
			$styles3 = array ('color' => $row->tx_color);
			$writer->writeSheetRow($sheet2, array('',$row->id_projeto.' - '.$row->tx_projeto,$row->horas,$row->despesas), $styles3 );
			
			}	
			$color += 1;
		}	
			
			
			
		}	
		//Query END , create DOCUMENT
		$periodo = str_replace('/','-',$dt_resumo);
		$writer->writeToFile('./storage/relatorio_mensal_'.$periodo.'.xlsx');
		header('Location: ./storage/relatorio_mensal_'.$periodo.'.xlsx');
	
		
?>