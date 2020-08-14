<?php 

declare(strict_types = 1);

class Response {    
    /**
     * success
     *
     * @var bool
     */
    private $success;    
    /**
     * httpStatusCode
     *
     * @var int
     */
    private $httpStatusCode;    
    /**
     * messages
     *
     * @var string
     */
    private $messages = [];   
    /**
     * data
     *
     * @var mixed
     */
    private $data;    
    /**
     * toCache
     *
     * @var bool
     */
    private $toCache = false;    
    /**
     * responseData
     *
     * @var array
     */    
    /**
     * responseData
     *
     * @var array
     */
    private $responseData = [];
    
    /**
     * setSuccess
     *
     * @param  bool $success
     * @return void
     */
    public function setSuccess(bool $success) {
        $this->success = $success;
    }
    
    /**
     * setHttpStatusCode
     *
     * @param  int $httpStatusCode
     * @return void
     */
    public function setHttpStatusCode(int $httpStatusCode) {
        $this->httpStatusCode = $httpStatusCode;
    }
    
    /**
     * setMessage
     *
     * @param  string $message
     * @return void
     */
    public function setMessage(string $messages) {
        $this->messages[] = $messages;
    }
    
    /**
     * setData
     *
     * @param  mixed $data
     * @return void
     */
    public function setData($data) {
        $this->data = $data;
    }
    
    /**
     * toCache
     *
     * @param  bool $toCache
     * @return void
     */
    public function toCache(bool $toCache) {
        $this->toCache = $toCache;
    }
    
    /**
     * send
     *
     * @return void
     */
    public function send() {
        header('Content-type: application/json; charset=utf-8');
        if($this->toCache === true) {
            header('Cache-control: max-age=60');
        }
        header('Cache-control: no-cache, no-store');
        if(($this->success !== true && $this->success !== false) || !is_numeric($this->httpStatusCode)) {
            http_response_code(500);
            $this->responseData['statusCode'] = 500;
            $this->responseData['success'] = false;
            $this->setMessage('Response creation error');
            $this->responseData['message'] = $this->message;
        }
        http_response_code($this->httpStatusCode);
        $this->responseData['statusCode'] = $this->httpStatusCode;
        $this->responseData['success'] = $this->success;
        $this->responseData['messages'] = $this->messages;
        $this->responseData['data'] = $this->data;
        echo json_encode($this->responseData);
    }
}