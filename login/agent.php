<?php 
// session_start inicia a sessão
session_start();
// as variáveis login e senha recebem os dados digitados na página anterior
/* 
    $login = $_GET['usuario'];
    $senha = $_GET['senha'];
 */
    $login = $_POST['usuario'];
    $senha = $_POST['senha'];
// as próximas 3 linhas são responsáveis em se conectar com o bando de dados.
$con = mysqli_connect("localhost", "root", "", "firesystems");
        // Check connection
        if (mysqli_connect_errno())
          {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }
 
// A variavel $result pega as varias $login e $senha, faz uma pesquisa na tabela de usuarios
$result = mysqli_query($con, "SELECT * FROM `USUARIO` WHERE `tx_name` = '$login' AND `tx_password`= '$senha'");
/* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
if(mysqli_num_rows ($result) >= 1 )
{
  while($row = mysqli_fetch_array($result)) {
     $var = Array(
        'usuario' =>   $row["tx_name"],
        'email' =>     $row["tx_email"],
        'categoria' => $row["nb_category_user"]
    );

    header('Content-Type: application/json');
    echo json_encode($var);

    /*
    echo "<script>var id_user=".$row['id_usuario']."</script>";
    echo "<script>var category_user=".$row['nb_category_user']."</script>";
    echo "<script>var name_user=".$row['tx_name']."</script>";
    echo "<script>var user_password=".$row['tx_password']."</script>";
    echo "<script>var user_email=".$row['tx_email']."</script>";
    */
  };
$_SESSION['login'] = $login;
$_SESSION['senha'] = $senha;
//header('location:index.php');
/*
echo  $array = array('username'=>$_SESSION['login'],
                     'passuordi'=>$_SESSION['senha'];
    echo json_encode($array);
/**/
  exit;
}
else{
  echo 0;
unset ($_SESSION['login']);
unset ($_SESSION['senha']);
session_destroy();
//  header('location:acess.php');
  exit;
}
 
?>