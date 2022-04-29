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
require("./controller/pedidosController.php");

if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Uptecnico')
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
    // set id_pedido
    $pid = $data['Pid'] = $_POST['Pid'];
    // set New filename
    $data['tx_arquivo'] = $_FILES['uploadedFile']['name'];
    // set descricao
    $data['tx_documento'] = $_POST['tx_documento'];
    // set descricao
    $data['nb_tamanho'] = $fileSize;
    // set date
    $data['dataUpload'] = date("Y-m-d", $_SERVER['REQUEST_TIME']);
    // set Doc Name from form Select
    $newFileName = $data['tx_arquivo'].'.'.$fileExtension;
    // check if file has one of the following extensions
    $allowedfileExtensions = array('dwg','pdf');
    
    if (in_array($fileExtension, $allowedfileExtensions))
    {
      
      // directory in which the uploaded file will be moved
      $uploadFileDir = './storage/tecnico/'.md5($pid);
      if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir);
      }
      $dest_path = $uploadFileDir .'/'. $newFileName;
      
      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      { 
        $fh = fopen($dest_path, "r");

        switch($fileExtension){
          case 'pdf': // READ PDF VERSION CODE
            $contents = fread($fh,9);
            $data['tx_version'] = substr($contents,-8);
            break;
          case 'dwg': // READ DWG AUTODESK VERSION CODE
            $contents = fread($fh,6);
              switch($contents){
                case 'AC1014': $data['tx_version'] = 'DWG Release 14';
                break;
                case 'AC1015': $data['tx_version'] = 'DWG AutoCAD 2000';
                break;
                case 'AC1018': $data['tx_version'] = 'DWG AutoCAD 2004';
                break;
                case 'AC1021': $data['tx_version'] = 'DWG AutoCAD 2007';
                break;
                case 'AC1024': $data['tx_version'] = 'DWG AutoCAD 2010';
                break;
                case 'AC1027': $data['tx_version'] = 'DWG AutoCAD 2013';
                break;
                case 'AC1032': $data['tx_version'] = 'DWG AutoCAD 2018';
                break;
                default : $data['tx_version'] = 'DWG AutoCAD';
                break;
              }
            break;
          }    
        fclose($fh);
        
        //print_r(implode(' ,',$data));
        insertArquivoTecnico($conn,$data);
        echo'Upload do arquivo: '.$fileName.' realizado com Sucesso!';
        
      }
      else
      {
        echo'Erro ao enviar arquivo!';
      }
    }
    else
    {
      echo'Erro ao enviar arquivo! Tipos de arquivos suportados: AutoCAD Drawing (DWG) ou Documento (PDF).';
    }
  }
  else
  {
    echo'Erro ao enviar arquivo!';
    
  }
}

