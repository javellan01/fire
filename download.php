<?php
session_start();

$token = md5(session_id());
if(!isset($_SESSION["login"]) || !isset($_GET['token']) ) 
		{ 
	// Usuário não logado! Redireciona para a página de login 
		header("Location: login.php"); 
		exit; 
	} 
	
	$id = $_GET['data'];
	$fname = $_GET['fname'];
	$fname = $_GET['fname'];
	
//	header('Location: ./storage/docs/'.$id.'/'.$fname.'');

	// File to download.
$file = './storage/docs/'.$id.'/'.$fname.'';

// Maximum size of chunks (in bytes).
$maxRead = 1 * 1024 * 1024; // 1MB
//docType
$doctype = $_GET['doctype'];
//relative
$relative = $_GET['relative'];
// Give a nice name to your download.
$fileName = $doctype.' - '.$relative.substr($fname,-4);

// Open a file in read mode.
$fh = fopen($file, 'r');

// These headers will force download on browser,
// and set the custom file name for the download, respectively.
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $fileName . '"');

// Run this until we have read the whole file.
// feof (eof means "end of file") returns `true` when the handler
// has reached the end of file.
while (!feof($fh)) {
    // Read and output the next chunk.
    echo fread($fh, $maxRead);
    // Flush the output buffer to free memory.
    ob_flush();
}

// Exit to make sure not to output anything else.
exit;

?>