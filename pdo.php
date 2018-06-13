<!DOCTYPE html>
<html><head>
	<meta lang='pt-BR'>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	</head>
	<body><h3>
<?php
	require('conn.php');
	
$sth = $conn->prepare("SELECT tx_nome, tx_cnpj FROM cliente WHERE id_cliente = 4");
$sth->execute();

/* Exercise PDOStatement::fetch styles */
print("PDO::FETCH_ASSOC: ");
print("Return next row as an array indexed by column name<br><br>");
$result = $sth->fetch(PDO::FETCH_ASSOC);
print_r($result);
print("<br><br>");

print("PDO::FETCH_BOTH: ");
print("Return next row as an array indexed by both column name and number<br><br>");
$result = $sth->fetch(PDO::FETCH_BOTH);
print_r($result);
print("<br><br>");

print("PDO::FETCH_LAZY: ");
print("Return next row as an anonymous object with column names as properties<br><br>");
$result = $sth->fetch(PDO::FETCH_LAZY);
print_r($result);
print("<br><br>");

print("PDO::FETCH_OBJ: ");
print("Return next row as an anonymous object with column names as properties<br><br>");
$result = $sth->fetch(PDO::FETCH_OBJ);
echo $result;
print("<br><br>");
	
	?>
	
	
		</h3>
	</body>
</html>	