<?php

class Response
{
    // class response properties
    private $success;
    private $httpStatusCode;
    private $message = [];
    private $data;
    private $responseData = [];

    /**
     * Set the success property
     * @param $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * Set the HTTP Status code property
     * @param $statusCode
     */
    public function setHttpStatusCode($statusCode)
    {
        $this->httpStatusCode = $statusCode;
    }

    /**
     * Add message to the property message Array
     * @param $message
     */
    public function addMessage($message)
    {
        $this->message[] = $message;
    }

    /**
     * Set the data property
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Send the request
     */
    public function send()
    {
        header('Content-type: application/json;charset=utf-8'); // set response to json with utf-8 charset
        if (($this->success !== false && $this->success !== true) || !is_numeric($this->httpStatusCode)) { // If success is not tru and not false there is a server error or the status code is not numeric
            http_response_code(500); // Server Error
            $this->responseData['status_code'] = 500; // set the error code to the json response
            $this->responseData['success'] = false; // set the 'success' to false (server_error)
            $this->addMessage('Internal server error'); // set error message
        } else {
            http_response_code($this->httpStatusCode); // set the status code for the response
            $this->responseData['status_code'] = $this->httpStatusCode;
            $this->responseData['success'] = $this->success;

        }

        echo json_encode($this->responseData);


    }
}