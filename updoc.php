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
require("./DB/conn.php");
require("./controller/funcionariosController.php");


function data_sql($data) {
  $ndata = substr($data, 6, 4) ."-". substr($data, 3, 2) ."-".substr($data, 0, 2);
  return $ndata;
}

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
    $fid = $data['Fid'] = $_POST['Fid'];
    // get Name
    $data['Text'] =  $_POST['Text'];
    // get vencimento
    $fileVenc = $data['dataVencimento'] = data_sql($_POST['dataVencimento']);
    // get date
    $fileDate = $data['dataUpload'] = date("Y-m-d", $_SERVER['REQUEST_TIME']);
    // set doctipo
    $data['docTipo'] = $_POST['DNome'];
    // get Doc Name from form Select
    $newFileName = $data['DNome'] = $_POST['DNome'].'_'.$fileDate.'.'.$fileExtension;
 
    // check if file has one of the following extensions
    $allowedfileExtensions = array('jpg','jpeg','pdf','png','doc','docx');
    
    if (in_array($fileExtension, $allowedfileExtensions))
    {
      // directory in which the uploaded file will be moved
      $uploadFileDir = './storage/funcionarios/'.md5($fid);
      if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir);
      }
      $dest_path = $uploadFileDir .'/'. $newFileName;
      
      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      { 
        
        // implode(',',$data);
        insertFDocumento($conn,$data);
        echo'Upload do arquivo: '.$_FILES['uploadedFile']['name'].' realizado com Sucesso!';
        
      }
      else
      {
        echo'Erro ao enviar arquivo!';
      }
    }
    else
    {
      echo'Erro ao enviar arquivo! Tipos de arquivos suportados: Imagem (JPG), Imagem (PNG), Documento (PDF) e Documento (DOC).';
    }
  }
  else
  {
    echo'Erro ao enviar arquivo!';
    
  }
}

