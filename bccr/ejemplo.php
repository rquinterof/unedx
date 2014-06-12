<?php

date_default_timezone_set('America/Costa_Rica');
error_reporting(0);

// EJEMPLO DE UTILIZACION
require_once("Indicador.php");

// Constructor recibe como parametro true si se va a usar SOAP, de lo contrario por defecto es false
$i = new Indicador(true);

// Metodo recibe el tipo de cambio Indicador::VENTA o Indicador::COMPRA
$valor = $i->obtenerIndicadorEconomico(Indicador::COMPRA);

echo "valor: " . $valor;

?>