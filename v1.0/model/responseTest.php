<?php
require_once ('Response.php');
// This is only for test
$response = new Response();
$response->setSuccess(true);
$response->setHttpStatusCode(200);
$response->addMessage('Test Message');
$response->send();
