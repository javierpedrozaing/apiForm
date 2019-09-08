<?php 
	function cleanHtml($doc){
		$ele = $doc->getElementsByTagName('*');
		foreach($ele as $e){
			$array[] = Dom2Array($e);
		}
		
		$result = reBuild($array);
		
		return Array2Dom($result);		
	}
	
	function reBuild($array) {
		
		if (!is_array($array))
			return;
		$helper = array();
		foreach ($array as $key => $value) {
			if(is_array($value))
				$helper[$key] = reBuild($value);
			else{
				if($value == 'table' || $value == 'tbody' || $value == 'tr' || $value == 'td')
					$helper[$key] = "div";
				else
					$helper[$key] = $value;
			}
		}
		
		return $helper;
	}
?>