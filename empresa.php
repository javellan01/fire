<!DOCTYPE html>
<html><head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-2">
</head>
<body style="margin: 60px;background-color: #999;font-size:" 80%"="">
	<!-- Seçăo 0001, um conto sobre o HTML -->
	<div style="color: #dd2211;">
		<h2> ACESSO BANCO DE DADOS GERAL<i> Sistema Firesystems </i>
		<br>
		<div style="border-style: dashed; color: #911">
		<ul style="list-style-type: disc">
			<li>Pedidos Relativos a:
				
<?php
 
$servername = "mysql.firesystems.com.br";
$username = "firesystems";
$password = "fire2014";

// Create connection

$conn = new PDO("mysql:host=mysql.firesystems.com.br;dbname=firesystems", "firesystems", "fire2014");

// Check connection

$empresa = 'ADN';
echo $empresa."<ul>";

$stmt = $conn->query("SELECT c.id_cliente, p.tx_codigo, p.cs_estado, v.medido_total, v.nb_valor FROM cliente As c 
						INNER JOIN pedido AS p ON c.id_cliente = p.id_cliente
						INNER JOIN v_sum_pedido_total AS v ON p.id_pedido = v.id_pedido
						WHERE c.tx_nome LIKE '" . $empresa . "'
						;");
						
//$stmt1 = $conn->query("SELECT c.id_cliente, p.tx_codigo, p.cs_estado FROM cliente As c 
//						INNER JOIN pedido AS p ON c.id_cliente = p.id_cliente
//						WHERE c.tx_nome LIKE '" . $empresa . "' AND p.cs_estado = 0;");	
					
if($stmt == NULL){
echo"<li> Năo Tem NADA. !! <li>";}

else{
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
  if($row->cs_estado == 0) 
  echo "<li style='color: #1122aa;'>";
  if($row->cs_estado == 1)
  echo "<li style='color: #ddaa44;'>";
  echo "Pedido Número: ";
  echo $row->tx_codigo . ", <td>";
  echo "Estado do Pedido: ";
 // echo $row->cs_estado . ", ";
  if($row->cs_estado == 0) 
	  echo "Ativo. <td>";
  if($row->cs_estado == 1) 
	  echo "Encerrado. <td>";
  echo"Valor Total do Pedido: R$";
  echo $row->nb_valor . ", <td>";
  $percent = $row->medido_total / $row->nb_valor;
  $percent = $percent * 100;
  echo"Total Medido: R$";
  echo $row->medido_total . ", <td>". $percent ."% do total do pedido.";
  echo "<li>";
}
}

?>

</ul>
			</li>
		</ul>
		
		</div>
		<br>		
</body></html> 