<?php 

	ini_set("display_errors", true);
	header('Access-Control-Allow-Origin: *');
	//require_once("validation.php");

	 $url 		= $_REQUEST['form'];//http://www.pages03.net/bancolombiainbound/FormulariodescargadecontenidoPrueba/Formulario-descarga-Comex/
	$content  	= file_get_contents($url);
	$content	= str_replace("src=\"", "src=\"http://www.pages03.net", $content);
	$content	= str_replace("<html dir=\"ltr\">", "", $content);
	$content	= str_replace("<html>", "", $content);
	$content	= str_replace("</span></span>", "</span>", $content);
	$content	= str_replace("<head>", "", $content);
	$content	= str_replace("</head>", "", $content);
	$content	= str_replace("<title>", "", $content);
	$content	= str_replace("</title>", "", $content);
	$content	= str_replace("<body>", "", $content);
	$content	= str_replace("<p>&nbsp;</p>", "", $content);
	$content	= str_replace("</body>", "", $content);
	$content	= str_replace("</html>", "", $content);
	//$content	= str_replace("action=\"", "target=\"submit_iframe\" action=\"http://www.pages03.net", $content);
	$content	= str_replace("<input type=\"hidden\"", "<input type=\"hidden\" name=\"sp_exp\" value=\"yes\"><input type=\"hidden\"", $content);
	$content	= preg_replace('/style="[a-zA-Z0-9:;\.\s\(\)\-\,]*"/', '', $content);

	//replace names and labels
	$dom = new DOMDocument('1.0', 'UTF-8');
	$internalErrors = libxml_use_internal_errors(true);
	$script = "<script>alert('test');</script>";
	$dom->loadHTML("<?xml encoding=\"utf-8\" ?>".$content);		
	$xpath = new DOMXpath($dom);

	$fields_types = array("input[@type='text']", "select", "input[@type='checkbox']");
	$totals = array();
	$types = array();
	
	foreach($fields_types as $field){
		$inputCount = $xpath->query("//".$field);
		foreach($inputCount as $tag) { 
			$label = $tag->getAttribute('label');
			$name = $tag->getAttribute('name');
			$type = $tag->getAttribute('type');
			$tag->setAttribute('style', '');
			$totals[$name] = $name;
			$types[$name] = $type;
		}
	}
		
	//replace scripts to fix automatic validation

	$html 		= $dom->saveHTML();	
	echo utf8_decode($html);
?>