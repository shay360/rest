<?php
/**
 * This is a response test, no need to use this file and can be deleted
 */
require_once ('Response.php');
// This is only for test
$response = new Response();
$response->setSuccess(true);
$response->setHttpStatusCode(200);
$response->addMessage('Test Message');
$response->send();
