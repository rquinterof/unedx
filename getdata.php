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
					"update" => date("d-m-Y H:i:s"),
					"oferta" => array()
				);

/*
array("cod" => "03333", "asignatura" => "", "I" => "", "II" => "X", "III" => ""),
								array("cod" => "03333", "asignatura" => "", "I" => "", "II" => "X", "III" => ""),
								array("cod" => "03333", "asignatura" => "", "I" => "", "II" => "X", "III" => ""),
								array("cod" => "03333", "asignatura" => "", "I" => "", "II" => "X", "III" => ""),
								array("cod" => "03333", "asignatura" => "", "I" => "", "II" => "X", "III" => ""),
*/


//dump($oferta_anual);

// Create DOM from URL or file
$html = file_get_html('http://www.uned.ac.cr/index.php/periodo-academico/62-oferta-anual-de-asignaturas/564-2014-oferta-anual-de-asignaturas');

$i = 0; $j=0;
$cod; $asig; $I; $II; $III;
// Find all images
foreach($html->find('td') as $element){

	if($i==3){
		$oferta_anual["anio"]=$element->innertext;
		//echo '('.$i.')'. $element->innertext . '<br>';
	}else if($i>=8){
		//echo '('.$i.')'. $element->innertext . '<br>';
		//array_push($oferta_anual["oferta"], array("codigo" => "03333", "asignatura" => "", "I" => "", "II" => "X", "III" => ""));	
		
		
		if($j<5){
			if($j==1){$curr=(count($oferta_anual["oferta"])-1);}
			//$curr=0;
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

//count($array) - 1
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

