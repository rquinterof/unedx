<?php

    //include('scrap/simple_html_dom.php');

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

	function dot($string){if(isset($_GET["dot"])=='true'){ return str_replace(",",".",$string);}else{ return $string;}}

    $variablee = get_data($source);
    //echo $variablee;

	//echo strlen($variablee);

	//echo "<code>".substr($variablee,40090,-3656)."</code>";
	$showoff = array("align='right' style='color:Black;background-color:White;font-family:Arial;font-size:10pt;'","align='left' style='color:White;'","align='right' style='color:Black;background-color:#DFEDFF;font-family:Arial;font-size:10pt;'"," align='left'","style='color:#000066;background-color:White;font-size:XX-Small;'","\n\r","align='right'","  ");
	$res = str_replace("\"", "'", substr($variablee,40869,-3664)); //do it manually - ubicacion del contenido
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
       $columns = explode("<|>",$rows[$i]); 
        //dump($columns);
        
        $j=0;
        foreach($columns as $value) {
          //$value['transaction_date'] = date('d/m/Y', $value['transaction_date']);
          
          switch($j){
              case 0: unset($columns[0]); break;// delete the first column - Tipo Entidad
              case 1: $dataset["exchange"][$i][$j]=$columns[$j]; break;
              case 2: 
              case 3:
              case 4: $dataset["exchange"][$i][$j]=dot($columns[$j]); break;
              case 5: $dataset["exchange"][$i][$j]=$columns[$j]; break;
              case 6; unset($columns[6]); break; // for delete last empty
          }  
     		$j++;
        }

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
        
        
        /*
        
        if(isset($_GET["dot"])=='true'){
            str_replace(".",",",$columns[2]);
            str_replace(".",",",$columns[3]);
        }
        */
        	//$dataset["exchange"][$i]=$columns;
        
        //dump($rows[$i]);
       /*
       for($j=0;$j<=(count($columns)-1);$j++){
       	//$dataset["currency"][$i]=$columns[$j];
       }*/
    } 
     	

	$data["data"] = $dataset;

	//save this data set
	// Config
	/*  
    $dbhost = 'localhost';  
    $dbname = 'exchange';  

    // Connect to test database  
    $m = new Mongo("mongodb://$dbhost");  
    $db = $m->$dbname;  

    // select the collection  
    $collection = $db->shows;  

    // pull a cursor query  
    $cursor = $collection->find();  

	dump($cursor);
    */
	


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