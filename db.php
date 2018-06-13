<!DOCTYPE html>
<html lang="pt-br"><head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body style="margin: 60px;background-color: #999;font-size:" 80%"="">
	<!-- Seção 0001, um conto sobre o HTML -->
	<div style="color: #dd2211;">
		<h2> ACESSO BANCO DE DADOS GERAL<i> Sistema Firesystems </i>
		<br>
		<div style="border-style: dashed; color: #911">
		<ul style="list-style-type: disc">
			<li>Tabela Atividade
				<ul>
<?php
 
$servername = "mysql.firesystems.com.br";
$username = "firesystems";
$password = "fire2014";

// Create connection

$conn = new PDO("mysql:host=mysql.firesystems.com.br;dbname=firesystems", "firesystems", "fire2014");

// Check connection

echo "Connected successfully";

$stmt = $conn->query("SELECT id_atividade, tx_descricao, tx_tipo, nb_qtd, nb_valor FROM atividade");

while($row = $stmt->fetch(PDO::FETCH_OBJ)){
  echo "<li>";
  echo "Atividade n: ";
  echo $row->id_atividade . ", <td>";
  echo "Descr.: ";
  echo $row->tx_descricao . ", <td>";
  echo "Tipo: ";
  echo $row->tx_tipo . ", <td>";
  echo "Quantidade: ";
  echo $row->nb_qtd . ", <td>";
  echo "Valor: R$";
  echo $row->nb_valor . ".<td>";
  echo "<li>";
}


?>

</ul>
			</li>
		</ul>
		
		</div>
		<br>		
</body></html> 