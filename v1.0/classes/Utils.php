<?php

class Utils
{
    public static function setErrorResponse($status)
    {
        $statusCodes = [
            'OK' => 200,
            'Created' => 201,
            'Accepted' => 202,
            'No Content' => 204,
            'Moved Permanently' => 301,
            'Found' => 302,
            'See Other' => 303,
            'Not Modified' => 304,
            'Temporary Redirect' => 307,
            'Bad Request' => 400,
            'Unauthorized' => 401,
            'Forbidden' => 403,
            'Not Found' => 404,
            'Method Not Allowed' => 405,
            'Not Acceptable' => 406,
            'Precondition Failed' => 412,
            'Unsupported Media Type' => 415,
            'Internal Server Error' => 500,
            'Not Implemented' => 501
        ];
        $errorMessage = array_flip($statusCodes);
        $response = new Response();
        $response->setHttpStatusCode($status);
        $response->setSuccess(false);
        $buildMessage = [
            'status_code' => $status,
            'message' => $errorMessage[$status]
        ];
        $response->addMessage($buildMessage);
        $response->send();
        exit;
    }
}