<?php 
	
	ini_set("display_errors", true);

	$url 		= "http://www.pages03.net/bancolombiainbound/bbddgeneral";
	$content  	= file_get_contents($url);

	$pattern = '/<script\b[^>]*>([\s\S]*?)<\/script>/i';
	preg_match_all($pattern, $content, $matches);

	foreach($matches[0] as $match){
		if (stripos($match, "Form_validation") !== false){
			$match = str_replace("<script src=\"", "http://www.pages03.net", $match);
			$match = str_replace("\" type=\"text/javascript\"></script>", "", $match);
		}
	}
	$script  	= file_get_contents($match);
	for($i=0; $i<20; $i++){
		if (stripos($script, "COLUMN".$i) !== false){
			echo "encontre ".$i." <br>";
		}
	}
?>