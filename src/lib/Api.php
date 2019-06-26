<?php

abstract class Api
{
    public $apiName = '';

    public $method = '';

    public $requestUri = [];
    public $requestParams = [];

    public $action = '';

    public function __construct()
    {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Content-Type: application/json");
        try {
            $this->init();
        } catch (Exception $e) {
        }
    }

    abstract public function viewUser();

    abstract public function createUser();

    abstract public function updateUser();

    abstract public function deleteUser();

    function init()
    {
        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $this->requestParams = $_REQUEST;

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE')
                $this->method = 'DELETE';
            else
                if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT')
                    $this->method = 'PUT';
                else
                    throw new Exception("Incorrect Header");
        }
    }

    public function run()
    {
        $this->action = $this->getAction();
        if (method_exists($this, $this->action))
            return $this->{$this->action}();
        else
            throw new RuntimeException('Invalid Method', 405);
    }

    public function response($data, $status = 500)
    {
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        return json_encode($data);
    }

    private function requestStatus($code)
    {
        $status = array(
            200 => 'OK',
            206 => 'Partial Content',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }

    public function getAction()
    {
        $method = $this->method;
        switch ($method) {
            case 'GET':
                return 'viewUser';
                break;
            case 'POST':
                return 'createUser';
                break;
            case 'PUT':
                return 'updateUser';
                break;
            case 'DELETE':
                return 'deleteUser';
                break;
            default:
                return null;

        }
    }
}