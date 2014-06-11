<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Busqueda de oferta académica</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

    <style>
    	body{
            background-color: #333;
            color: #999;
            
        }
        xmp{
            font-family: 'Open Sans', sans-serif;
            font-size: 11px;
        }
    </style>
    
    </head>
<body>
        
    
<?php

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
        					 '<tr >' => ''
                            );
	$res = strtr($res,$array_from_to);
	$purge = (string)$res;

	echo "<xmp>".$purge."</xmp>";

	// vamos a cortar el archivo
	

	echo "<hr>";

	//$html = new simple_html_dom();
	//$html = str_get_html(htmlentities($purge));
	//dump($html);	

	echo "<hr>";
	
	$DOM = new DOMDocument;
	$DOM->validateOnParse = true;
   		//$DOM->loadHTML("<div id='fran' style='background-color: #333;'>hello world</div>");
		//echo $DOM->getElementById("fran")->nodeValue;
	//$DOM-loadHTML($purge);
	
	//dump($variablee);


?>
        
        </body>
    </html>