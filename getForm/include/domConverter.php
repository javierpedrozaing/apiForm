<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);
/**
 * Recursive function to turn a DOMDocument element to an array
 * @param DOMDocument $root the document (might also be a DOMElement/DOMNode?)
 */
function Dom2Array($root) {
    $array = array();
    //list attributes
    if($root->hasAttributes()) {
        foreach($root->attributes as $attribute) {
            $array['_attributes'][$attribute->name] = $attribute->value;
        }
    }
    //handle classic node
    if($root->nodeType == XML_ELEMENT_NODE) {
        $array['_type'] = $root->nodeName;
        if($root->hasChildNodes()) {
            $children = $root->childNodes;
            for($i = 0; $i < $children->length; $i++) {
                $child = Dom2Array( $children->item($i) );
                //don't keep textnode with only spaces and newline
                if(!empty($child)) {
                    $array['_children'][] = $child;
                }
            }
        }
    //handle text node
    } elseif($root->nodeType == XML_TEXT_NODE || $root->nodeType == XML_CDATA_SECTION_NODE) {
        $value = $root->nodeValue;
        if(!empty($value)) {
            $array['_type'] = '_text';
            $array['_content'] = $value;
        }
    }
    return $array;
}
/**
 * Recursive function to turn an array to a DOMDocument
 * @param array       $array the array
 * @param DOMDocument $doc   only used by recursion
 */
function Array2Dom($array, $doc = null) {
   // print_r($array);
    //print_r($array[2]['_children']);
	if($doc == null) {
        
        $doc = new DOMDocument();
        $doc->formatOutput = true;
        $currentNode = $doc;
        //var_dump($currentNode);
    } 


    foreach ($array as $key => $value) {
        
        if (isset($value['_type'])) {

            if ($value['_type'] != 'option'){
                $newElement = $doc->createElement($value['_type']);
                $newNode = $doc->appendChild($newElement);                        
            }
            
            if ($value['_type'] == 'select') {
                $selectElement = $doc->createElement($value['_type']);
                $selectNode = $doc->appendChild($newElement);                        
            }

            if ($value['_type'] == 'option'){
                foreach ($value['_children'] as $key => $child) {
                    $newOption = $doc->createElement('option');
                    $textNode = $doc->createTextNode($child['_content']);
                    $option = $newOption->appendChild($textNode);                        
                    $newSelect = $selectNode->appendChild($newOption);                        
                }
                
            }

            
            
            if ($value['_type'] == 'div') {                    
                if (isset($value['_children'])) {  
                    foreach ($value['_children'] as $key => $child) {
                        //$newElementChild = $doc->createElement($value['_type']);
                        //$newNodeChild = $doc->appendChild($newElement);    
                        //$chidText = $child['_children'][0]['_children'][0]['_children'][0]['_children'][0]['_children'][0];          
                        if ($child['_type'] == '_text') {                                                   
                            $textNode = $doc->createTextNode($child['_content']);
                            $newTextNode = $newNode->appendChild($textNode);
                        }
                        
                    }    
                }
            }

            if ($value['_type'] == 'span') {
                //print_r($value['_children']);
                foreach ($value['_children'] as $key => $child) {
                    //print_r($child['_content']);
                    if ($child['_content'] != '*') {
                        $newSpan = $doc->createElement('span');
                        $textSpan = $doc->createTextNode($child['_content']);
                        $spanText = $newSpan->appendChild($textSpan);   
                        $nodeSpan = $newNode->appendChild($spanText);                     
                    }
                    
                }
                
            }

            if ($value['_type'] == 'label') {
                foreach ($value['_children'] as $key => $child) {
                    if ($child['_content'] != '*') {
                        $newSpan = $doc->createElement('label');
                        $textSpan = $doc->createTextNode($child['_content']);
                        $spanText = $newSpan->appendChild($textSpan);   
                        $newnodeSpan = $newNode->appendChild($spanText); 
                    }
                    if ($child['_type'] == 'a') {
                        foreach ($child['_children'] as $key => $children) {
                            $newSpan = $doc->createElement('a');
                            $textSpan = $doc->createTextNode($children['_content']);
                            $spanText = $newSpan->appendChild($textSpan);   
                            $nodeSpan = $newnodeSpan->appendChild($spanText); 
                        }
                        
                    }
                        
                }
            }
        }
        if ($value['_attributes']) {

            foreach ($value['_attributes'] as $key => $attr) {                
                $newElement->setAttribute($key, $attr);
            }             
        }
       
    }


    return $doc;

    
}
?>