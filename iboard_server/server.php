<?php

// Verify that SOAP extension is enabled
if (!extension_loaded('soap')) {
  die('SOAP extension not enabled. Please check your PHP configuration.');
}

class MySoapServer {
  public function displayString($message) {
    $data = array('message' => $message, 'timestamp' => time());
    $json = json_encode($data);
    file_put_contents('messages.json', $json . "\n", FILE_APPEND);
    return $message;
  }
}

$options = array(
  'uri' => 'http://example.com/soap',
  'location' => 'http://localhost:1234/Test/server.php'
);

$server = new SoapServer(null, $options);
$server->setClass('MySoapServer');
$server->handle();

?>
