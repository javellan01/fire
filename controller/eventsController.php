<?php

/* 	function data_usql($data) {
		$ndata = substr($data, 8, 2) ."/". substr($data, 5, 2) ."/".substr($data, 0, 4);
		return $ndata;
	} */
	
	function cat_color($cat){
		$color = '#343236';
		if($cat == 9) $color = '#777777';
		if($cat == 5) $color = '#ce3500';
		if($cat == 6) $color = '#f8a300';
		if($cat == 7) $color = '#65623c';
		if($cat == 8) $color = '#46554f';
		if($cat == 1) $color = '#457725';
		if($cat == 2) $color = '#646e83';
		if($cat == 3) $color = '#09568d';
		if($cat == 4) $color = '#172035';
			
		return $color;
	}
	
	//Calendario.php --- Carrega todas as atividades desse cliente no calendario

		//$mes = $_GET['mes'];
		//$ano = $_GET['ano'];
function getEventUsuResponsavel($conn,$uid){

    $stmt = $conn->query("SELECT a.*,p.tx_codigo,cat.tx_nome, cat.tx_color FROM atividade a 
                        INNER JOIN pedido p ON a.id_pedido = p.id_pedido 
                        INNER JOIN categoria cat ON a.id_categoria = cat.id_categoria 
                        WHERE p.id_usu_resp = $uid AND a.cs_finalizada = 0 AND NOT a.dt_inicio = '00-00-0000'");
    
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;

	}
			
function fillUCalendar($conn,$uid){

    $data = getEventUsuResponsavel($conn,$uid);
    echo "[ ";
    foreach($data as $event){
        if($event->cs_finalizada == 1) {
            $color = cat_color(9);
            $status = 'Encerrada';
        }	
        if($event->cs_finalizada == 0){ 
            $color = $event->tx_color;
            $status = 'Ativa';
            }
        $url = "#";
        $periodo = 'Início: '.data_usql($event->dt_inicio).' - Término: '.data_usql($event->dt_fim);
        
        echo "{ title: '".$event->tx_descricao."', start:'".$event->dt_inicio."', end:'".$event->dt_fim."T18:00:00',url:'".$url."', color:'".$color."', status:'".$status."', pedido:'".$event->tx_codigo."', categoria:'".$event->tx_nome."', periodo:'".$periodo."', allDay: false},";
    }
    echo " ]";
}

function getEventAtividadeExecutada($conn,$aid){

    $stmt = $conn->query("SELECT aex.*, u.tx_name, a.tx_tipo FROM atividade_executada AS aex  
                        INNER JOIN atividade AS a ON aex.id_atividade = a.id_atividade
                        INNER JOIN usuario AS u ON aex.id_usuario = u.id_usuario
                        WHERE aex.id_atividade = $aid");
    
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $data;

	}

    function getEventAtividadeMedida($conn,$aid){

        $stmt = $conn->query("SELECT aem.*, m.dt_data, a.nb_valor AS nb_total FROM atividade_medida AS aem  
                            INNER JOIN medicao AS m ON aem.id_pedido = m.id_pedido
                            INNER JOIN atividade AS a ON aem.id_atividade = a.id_atividade
                            WHERE aem.id_atividade = $aid");
        
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    
        return $data;
    
        }

function fillInfoAtividadeCalendar($conn,$aid){

    $data0 = getEventAtividadeExecutada($conn,$aid);
    $data1 = getEventAtividadeMedida($conn,$aid);
    $events= array();
    echo "[ ";
    foreach($data0 as $event){
        $color = cat_color(6); 

        $evento = array();
            
        $evento['title'] = 'Cadastro de Progresso';
        $evento['start'] = $event->dt_data;
        $evento['end'] = $event->dt_data;
        $evento['color'] = $color;
        $evento['quantidade'] = $event->nb_qtd.$event->tx_tipo;
        $evento['usuario'] = $event->tx_name;
        $evento['allDay'] = 'true';

        $events += $evento;        
        echo "{ title: 'Cadastro de Progresso', start:'".$event->dt_data."', end:'".$event->dt_data."',
             color:'".$color."', quantidade:'".$event->nb_qtd."', usuario:'".$event->tx_name."', allDay: true},";
        
    }
    foreach($data1 as $event){
        $percent = ($event->nb_valor / $event->nb_total)*100;
        $percent = number_format($percent,2,',','.');
        $color = cat_color(3);
        $evento = array();
            
        $evento['title'] = 'Progresso Medido';
        $evento['start'] = $event->dt_data;
        $evento['end'] = $event->dt_data;
        $evento['color'] = $color;
        $evento['medidos'] = $percent;
        $evento['medicao'] = $event->nb_ordem;
        $evento['allDay'] = 'true';

        $events += $evento;

        echo "{ title: 'Progresso Medido', start:'".$event->dt_data."', end:'".$event->dt_data."', 
            color:'".$color."', url:'#', medicao:'".$event->nb_ordem."', medidos:'".$percent."', allDay: true},";

        }        

        //$output = json_encode($events);
        //echo $output;
        echo " ]";


}

?>