<?php

error_reporting(E_ALL);

include('scrap/simple_html_dom.php');

function dump($data) {
        if(is_array($data)) { //If the given variable is an array, print using the print_r function.
            print "<pre>-----------------------\n";
            print_r($data);
            print "-----------------------</pre>";
        } elseif (is_object($data)) {
            print "<pre>==========================\n";
            var_dump($data);
            print "===========================</pre>";
        } else {
            print "=========&gt; ";
            var_dump($data);
            print " &lt;=========";
        }
    }


$oferta_anual = array(
					"anio" => "",
					"last_update" => date("d-m-Y H:i:s"),
					"oferta_anual" => array()
				);

//dump($oferta_anual);

// Create DOM from URL or file
$html = file_get_html('http://www.uned.ac.cr/index.php/periodo-academico/62-oferta-anual-de-asignaturas/564-2014-oferta-anual-de-asignaturas');

$i=0; $j=0;

// Find all images
foreach($html->find('td') as $element){

	if($i==3){
		$oferta_anual["anio"]=str_replace("&nbsp;", '', strip_tags($element->innertext));
		//echo '('.$i.')'. $element->innertext . '<br>';
	}else if($i>=8){
		//echo '('.$i.')'. $element->innertext . '<br>';		
		if($j<5){
			if($j==1){$curr=(count($oferta_anual["oferta"])-1);}
			switch ($j) {
				case 0: array_push($oferta_anual["oferta"], array("codigo" => strip_tags(html_entity_decode($element->innertext)), "asignatura" => "", "I" => "", "II" => "", "III" => "")); $j++; break;
				case 1: $oferta_anual["oferta"][$curr]["asignatura"]=strip_tags(html_entity_decode($element->innertext)); $j++; break;
				case 2: $oferta_anual["oferta"][$curr]["I"]=strip_tags(html_entity_decode($element->innertext)); $j++; break;
				case 3: $oferta_anual["oferta"][$curr]["II"]=strip_tags(html_entity_decode($element->innertext)); $j++; break;
				case 4: $oferta_anual["oferta"][$curr]["III"]=strip_tags(html_entity_decode($element->innertext)); $j=0; break;
			}
		}
	}
	
	$i++;
}
//$html->plaintext;

// Find all links
//foreach($html->find('a') as $element)
  //     echo $element->href . '<br>';

//dump($oferta_anual);

$data["data"] = $oferta_anual;

header('Content-Type: text/json');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode($data);

//$curr = count($oferta_anual["oferta"])-1;
//dump($oferta_anual["oferta"][$curr]["II"]);
//echo count($oferta_anual["oferta"])-1;

?>

