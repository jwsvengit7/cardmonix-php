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
}

?>