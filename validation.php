<?php 
	function setValidationScript($total){
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
		foreach($total as $key=>$value){
			if (stripos($script, $key) !== false){
				$script = str_replace($key, $value, $script);
			}
		}
		//$script = str_replace("container", "control", $script);
		//$script = str_replace("\") && isControlValid", "_\") && isControlValid", $script);
		return $script;
	}

	function setIncludeScripts(){
		$url = "http://www.pages03.net/LP_CONTENT/static/js/validation.js";
		$script  	= file_get_contents($url);
		$script = str_replace("getElementsByName", "getelementById", $script);
		//return $script;
	}

	function slugify($text){
		/*$text = preg_replace('~[^\pL\d]+~u', '_', $text);
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		$text = preg_replace('~[^-\w]+~', '', $text);
		$text = trim($text, '_');
		$text = preg_replace('~-+~', '_', $text);
		$text = strtolower($text);
		if (empty($text))
			return 'n-a';*/
		return $text;
	}
?>