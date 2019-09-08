<?php 

	ini_set("display_errors", true);
	header('Access-Control-Allow-Origin: *');
	require_once("validation.php");

	$url 		= 'http://samples.quadi.io/api-forms/pruebas_pacho.html';//$_REQUEST['form'];
	$content  	= file_get_contents($url);
	//$content 	= mb_convert_encoding( $content, '', 'UTF-8' );

	$doc = new \DOMDocument('1.0', 'UTF-8');
	$doc->recover = true;
	$doc->strictErrorChecking = false;
	$doc->loadHTML($content);
	$xpath = new DOMXPath( $doc );
	$bodyDescendants = $xpath->query( '//body//node()' );
	
	foreach($bodyDescendants as $child){
		echo $child->nodeName."<br>";   //output "div span div div"
    }
	
?>