<?php 

	ini_set("display_errors", false);
	require_once 'include/util.php';
	require_once 'include/domConverter.php';
	//header('Access-Control-Allow-Origin: *');
	if(isset($_GET["debug"]) && $_GET["debug"] != ''){
		$base 		= 'http://www.pages03.net/';
		$url 		= 'bancolombiainbound/FormulariodescargadecontenidoPrueba/Formulario-descarga-Comex/';//$_REQUEST['form'];//bancolombiainbound/FormulariodescargadecontenidoPrueba/Formulario-descarga-Comex/
		$content  	= file_get_contents($base.$url);		
		
		//set the document as Doom Object
		$doc = new \DOMDocument('1.0', 'UTF-8');
		$doc->recover = true;
		$doc->strictErrorChecking = true;
		$success = $doc->loadHTML($content);	
		//replace the TABLE tag
		$doc = cleanHtml($doc);
	//	var_dump($doc);
		echo $doc->saveHTML();

	}else{
		header("HTTP/1.1 401 Unauthorized");
		echo json_encode(array('response' => 'error_domain_no_authorized'));
		exit;
	}
?>