 <?php
$servername = "sql50.main-hosting.eu";
$username = "u658453311_fire";
$password = "fiream2014";
$dbname = "u658453311_fire";

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