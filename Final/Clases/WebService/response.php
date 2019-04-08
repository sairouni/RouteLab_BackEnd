<?php

class Response {
public $message;
public $data;
function __construct($message, $data = "") {
$this->message = $message;

$this->data = $data;
}
//(String) en $data por si no funciona algo
function __toString() {
return json_encode($this);
}
}
