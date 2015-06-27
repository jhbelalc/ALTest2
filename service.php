<?php
include 'host.php';

try {
    $request = new Request();
    $request->process();
} catch (Exception $e) {
    header("Status: 401");
    print $e->getMessage();
}

class Request
{
    private $class;
    private $method;
    private $id;
    private $content_type;


    public function __construct()
    {
        foreach (array('class', 'method', 'id') as $key) {
            if (array_key_exists($key, $_REQUEST)) {
                $this->$key = $_REQUEST[$key];
            }
        }
        switch ($_SERVER['HTTP_ACCEPT']) {
            case 'text/javascript':
            case 'application/json':
                $this->content_type = 'json';
                break;

            case 'text/xml':
            default:
                $this->content_type = 'xml';
                break;
        }
    }


    public function process()
    {
        if (!class_exists($this->class)) {
            throw new Exception("Service class does not exist");
        }

        if (!method_exists($this->class, $this->method)) {
            throw new Exception("Serivce {$this->class} method does not exist");
        }
        $obj = new $this->class();
        if (isset($this->id)) {
            $obj->$this->method($this->id);
        }

        $data = call_user_func(array($obj, $this->method));

        $this->output($data);
    }


    private function output($data)
    {
        switch ($this->content_type) {
            case 'json':
                $this->outputJSON($data);
                break;

            case 'xml':
            default:
                $this->outputXML($data);
                break;
        }
    }


    private function outputXML($data)
    {
        $root_name = strtolower($this->class) . "-" . strtolower($this->method);
        $dom       = new DOMDocument('1.0', 'iso-8859-1');
        $root      = $dom->createElement($root_name, '');
        
        foreach ($data as $values) {
            $element = $dom->createElement(strtolower($this->class), '');
            foreach ($values as $prop => $prop_value) {
                    $prop_element = $dom->createElement($prop, $prop_value);
                    $element->appendChild($prop_element);
            }
            $root->appendChild($element);
        }
        
        $dom->appendChild($root);

        header("Content-Type:text/xml");
        echo $dom->saveXML();
    }


    private function outputJSON($data)
    {
        $root_name = strtolower($this->class) . "-" . strtolower($this->method);
        $data      = array($root_name => $data);

        header("Content-Type:application/json");
        echo json_encode($data);
    }
}