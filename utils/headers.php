<?php
class Headers {
    private $headers;

    public function __construct($headers){
        $this->headers=$headers;

    }

    public function getHeaders(){
        $request_uri = $this->headers;

        $parts = explode('/', $request_uri);

        $userId = end($parts);

      return  $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);


    }
        public function getHeadersInString(){
        $request_uri = $this->headers;

        $parts = explode('/', $request_uri);

        $value = end($parts);

      return  $value = filter_var($value, FILTER_SANITIZE_STRING);


    }
}

?>