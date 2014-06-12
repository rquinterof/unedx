<?php

    include('scrap/simple_html_dom.php');

	date_default_timezone_set('America/Costa_Rica');
	$fech = getdate();

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


    //dump($oferta_anual);

    // Create DOM from URL or file
    //$html = file_get_html('http://indicadoreseconomicos.bccr.fi.cr/indicadoreseconomicos/cuadros/frmconsultatcventanilla.aspx');

    //dump($html);
    
	
    $source = 'http://indicadoreseconomicos.bccr.fi.cr/indicadoreseconomicos/cuadros/frmconsultatcventanilla.aspx';

	//$variablee = readfile($source);

	//$html = str_get_html($variablee); // no funciona por que el file tiene javas and other trash

	//dump($html);
    
	function get_data($url) {
      $ch = curl_init();
      $timeout = 5;
      curl_setopt($ch, CURLOPT_URL, $url);
      //curl_setopt($ch, CURLOPT_POST, TRUE);             // Use POST method
      //curl_setopt($ch, CURLOPT_POSTFIELDS, "var1=1&var2=2&var3=3");  // Define POST data values
      //curl_setopt($ch, CURLOPT_POSTFIELDS, "__EVENTARGUMENT=5274&__EVENTTARGET=Calendar1&__EVENTVALIDATION=/wEWCALBsJ+JCQLCiK2WCwLNsZb7BgKM54rGBgL1uYrHDwL3/dLRAwLwqrqvAgKf/ru8Dfx9a+GlWqpjc3CKsvkOUboyH8DJ&__VIEWSATE=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");  // Define POST data values
      curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
      curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
    }

    $variablee = get_data($source);
    //echo $variablee;

	//echo strlen($variablee);

	//echo "<code>".substr($variablee,40090,-3656)."</code>";
	$showoff = array("align='right' style='color:Black;background-color:White;font-family:Arial;font-size:10pt;'","align='left' style='color:White;'","align='right' style='color:Black;background-color:#DFEDFF;font-family:Arial;font-size:10pt;'"," align='left'","style='color:#000066;background-color:White;font-size:XX-Small;'","\n\r","align='right'","  ");
	$res = str_replace("\"", "'", substr($variablee,40869,-3664)); //do it manually
	$res = str_replace($showoff,"",$res);
	$array_from_to = array (
                             '</tr>' => '<||>',
                             '</td>' => '<|>',
        					 '<tr>'  => '',
        					 '<td>'  => '',
        					 '<tr >' => '',
        					 '<td >' => ''
                            );
	$res = strtr($res,$array_from_to);
	$purge = trim(preg_replace('/\s\s+/', '', $res));
	
	$dataset = array(
                        "title" => "CRC<=>USD Currency",
                        "last_update" => $fech,
                        "exchange" => array()
                    );
	
	$rows = explode("<||>",$purge);
	//dump(count($rows));
	
    //Tipo de Entidad	Entidad Autorizada	Compra	Venta	Diferencial Cambiario	Última Actualización
	$lasttype = "";    
	for($i=0;$i<=(count($rows)-3);$i++){
       $columns = explode("<|>",$rows[$i]); unset($columns[6]);
        //dump($columns);
        
        
        /*
        if($columns[0]!='&nbsp;'){
        	$lasttype=$columns[0];
        }        
        if($columns[0]=='&nbsp;'){
            $dataset["currency"][$i][0]=$lasttype;
        }else{
            $dataset["currency"][$i]=$columns;
        }
        */
        
        $dataset["exchange"][$i]=$columns;
        
        
        //dump($rows[$i]);
       /*
       for($j=0;$j<=(count($columns)-1);$j++){
       	//$dataset["currency"][$i]=$columns[$j];
       }*/
    } 
     	

	$data["data"] = $dataset;


	//dump($fech["year"]);
	// Habilitar para ofrecer el servicio
	
    header('Content-Type: text/json');
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');
    

	/*
	 1- se puede enviar paramentro para indicar que los tipos de cambio 
     utilice punto decimal, en lugar de coma
     2- puede solicitarse llave para realizar la consulta:token
     3- todovia no se
     */

    echo json_encode($data);

	//echo "<xmp>".$purge."</xmp>";

	// vamos a cortar el archivo
	

	//echo "<hr>";

	//$html = new simple_html_dom();
	//$html = str_get_html(htmlentities($purge));
	//dump($html);	

	//echo "<hr>";
	
	//$DOM = new DOMDocument;
	//$DOM->validateOnParse = true;
   		//$DOM->loadHTML("<div id='fran' style='background-color: #333;'>hello world</div>");
		//echo $DOM->getElementById("fran")->nodeValue;
	//$DOM-loadHTML($purge);
	
	//dump($variablee);


?>