<?php

class Response {
public $message;
public $data;
function __construct($message, $data = "") {
$this->message = $message;

$this->data = (String)$data;
}
function __toString() {
return json_encode($this);
}
}