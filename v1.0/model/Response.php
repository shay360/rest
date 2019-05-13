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
        if ($this->serverError()) { // If success is not tru and not false there is a server error or the status code is not numeric
            http_response_code(500); // Server Error
            $this->addMessage('Internal server error'); // set error message
            $this->responseData['messages'] = $this->messages; // Add the messages Array (in this case 'Internal server error'
            $this->responseData['status_code'] = 500; // set the error code to the json response
            $this->responseData['success'] = false; // set the 'success' to false (server_error)
        } else {
            http_response_code($this->httpStatusCode); // set the status code for the response
            $this->responseData['data'] = $this->data;
            $this->responseData['messages'] = $this->messages;
            $this->responseData['status_code'] = $this->httpStatusCode; // set the response status code
            $this->responseData['success'] = $this->success; // set the response success status
        }
        echo json_encode($this->responseData, JSON_UNESCAPED_SLASHES); // return the response as json encoded
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