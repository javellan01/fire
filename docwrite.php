<?php
require("./DB/conn.php");
require("./xlsxwriter.class.php");

$result = $result0 = $dt_resumo = $e = '';
$data = array();

if(isset($_POST['dt_resumo']) && $_POST['dt_resumo'] != ''){
		$dt_resumo = $_POST['dt_resumo'];
		$sheet='Projetos '.$dt_resumo;
		$styles1 = array( 'font-size'=>12,'font-style'=>'bold');
		$styles3 = array( [],['halign'=>'right'],[],[]);
		$result0=$conn->query("SELECT v.tx_color, v.id_projeto, v.tx_projeto, SUM(v.nb_horas) as total_horas, SUM(v.nb_despesas) as total_despesas FROM v_resumo_mensal v WHERE dt_resumo LIKE '".$dt_resumo."' GROUP BY v.id_projeto");
		$n_proj = $result0->rowCount()." Projetos";
		$writer = new XLSXWriter();
		//Write XLS MetaData
		$writer->setTitle('Resumo Mensal dos Projetos');
		$writer->setSubject('Relatorio');
		$writer->setAuthor('SistemaPoliPHT');
		$writer->setCompany('Politecnia Engenharia');
		//Write Cabeçalho
  		$writer->writeSheetHeader($sheet, array('Cod. Projeto' => 'string',
												'Nome' => 'string',
												'Horas' => 'integer',
												'Despesas' => '[$R$-1009] #,##0.00'),
												$col_options = array('widths'=>[10,72,13,20] ));
	 	$writer->markMergedCell($sheet, $start_row=1, $start_col=0, $end_row=1, $end_col=1);
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