 <?php
$servername = "mysql.firesystems.com.br";
$username = "firesystems";
$password = "fire2014";
$dbname = "firesystems";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }


?> 