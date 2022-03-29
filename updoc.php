<?php
session_start();

if(!isset($_SESSION["login"]) || !isset($_SESSION["usuario"])) 
		{ 
	// Usuário não logado! Redireciona para a página de login 
		header("Location: login.php"); 
		exit; 
	} 
require("./controller/agentController.php");
Auth::accessControl($_SESSION['catuser'],0);	 


$message = ''; 
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Updoc')
{
  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
  {
    // get details of the uploaded file
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    
    //built data Array to insert in dataBase
    $data = array();
    // get id_funcionario
    $fid = $data[0] = $_POST['Fid'];
    // get Name
    $data[1] =  $_POST['Text'];
    // get vencimento
    $fileVenc = $data[3] = $_POST['dataVencimento'];
    // get date
    $fileDate = $data[4] = date("Y-m-d", $_SERVER['REQUEST_TIME']);

    // get Doc Name from form Select
    $newFileName = $data[2] = $_POST['DNome'].'_'.$fileDate.'.'.$fileExtension;
 
    // check if file has one of the following extensions
    $allowedfileExtensions = array('jpg','pdf','png','doc');
    
    if (in_array($fileExtension, $allowedfileExtensions))
    {
      // directory in which the uploaded file will be moved
      $uploadFileDir = './docs/'.$fid.'/';
      $dest_path = $uploadFileDir . $newFileName;
 
      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      {
        echo implode(',',$data);
        //insertFDocumento($conn,$data);
        return $message ='Upload realizado com Sucesso!';
        
      }
      else
      {
        return $message = 'Erro ao enviar arquivo.';
      }
    }
    else
    {
      return $message = 'Erro ao enviar arquivo. Tipos de arquivos: ' . implode(',', $allowedfileExtensions);
    }
  }
  else
  {
    return $message = 'Erro ao enviar arquivo. Verifique o problema a seguir.<br>';
    return $message .= 'Error:' . $_FILES['uploadedFile']['error'];
  }
}
$_SESSION['message'] = $message;
