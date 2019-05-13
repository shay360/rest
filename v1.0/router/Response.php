<?php

class Response
{
    // class response properties
    private $success;
    private $httpStatusCode;
    private $messages = [];
    private $data;
    private $toCache = false; // cache response
    private $responseData = [];

    /**
     * Set the success status of the request
     *
     * @param (Bool) $success
     *
     * @since 1.0.0
     * @author Shay Zeevi
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * Set the HTTP Status code property
     *
     * @param (Integer) $statusCode
     *
     * @since 1.0.0
     * @author Shay Zeevi
     */
    public function setHttpStatusCode($statusCode)
    {
        $this->httpStatusCode = $statusCode;
    }

    /**
     * Add message to the request response (Array)
     *
     * @param (String) $message
     *
     * @since 1.0.0
     * @author Shay Zeevi
     */
    public function addMessage($message)
    {
        $this->messages[] = $message;
    }

    /**
     * Set the data property
     * The data property will be the actual response / results that the user asks for
     * @param $data
     *
     * @since 1.0.0
     * @author Shay Zeevi
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Set the toCache property
     *
     * @param (Bool) $toCache
     * @author Shay Zeevi
     */
    public function toCache($toCache)
    {
        $this->toCache = $toCache;
    }

    /**
     * Build the response data and send the response as json encode
     *
     * @since 1.0.0
     * @author Shay Zeevi
     */
    public function send()
    {
        header('Content-type: application/json;charset=utf-8'); // set response to json with utf-8 charset
        $this->toCache == true ? header('Cache-control: max-age=120') : header('Cache-control: no-cache, no-store'); // Set cache or no-cache
        if ($this->serverError()) {
            http_response_code(500);
            $this->addMessage('Internal server error');
            $this->responseData['messages'] = $this->messages;
            $this->responseData['status_code'] = 500;
            $this->responseData['success'] = false;
        } elseif (!$this->authSent()) {
            http_response_code(401);
            $this->addMessage('Authorization header not sent');
            $this->responseData['messages'] = $this->messages;
            $this->responseData['status_code'] = 500;
            $this->responseData['success'] = false;
        } else {
            http_response_code($this->httpStatusCode);
            $this->responseData['data'] = $this->data;
            $this->responseData['messages'] = $this->messages;
            $this->responseData['status_code'] = $this->httpStatusCode;
            $this->responseData['success'] = $this->success;
        }
        echo json_encode(); // return the response as json encoded
    }

    /**
     * Check Autho Header will check if there is Authorization header sent with the request
     * @return bool
     */
    private function authSent()
    {
        $headers = apache_request_headers();
        return isset($headers['Authorization']) && $headers['Authorization'] === '26633b0b3fb5007df2c7f969c46829c8' ? true : false;
    }


    /**
     * This method will check the success and http status code and if some of them will be false the method will return true
     * The true means, yes, there is a server error
     *
     * @return bool
     *
     * @since 1.0.0
     * @author Shay Zeevi
     */
    private function serverError()
    {
        // If there is a server error it will return true i.e 'There is a server error'
        return ($this->success !== false && $this->success !== true) || !is_numeric($this->httpStatusCode) ? true : false;
    }
}