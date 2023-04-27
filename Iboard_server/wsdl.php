<?php

// Verify that SOAP extension is enabled
if (!extension_loaded('soap')) {
  die('SOAP extension not enabled. Please check your PHP configuration.');
}

// Define the location of the WSDL file
$wsdl = "http://localhost:8081/Test";

// Create a new SOAP server object with the WSDL file
$server = new SoapServer($wsdl);

// Register the "displayString" function with the server
$server->addFunction('displayString');

// Generate the WSDL file and output it
header("Content-Type: text/xml");
echo $server->getWSDL();

?>
