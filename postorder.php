<?php

class postorder {
private $memberno;
private $poststat;

function __construct($memberno,$poststat) {
$this->memberno=$memberno;
$this->poststat=$poststat;

}
public function getmember() {
   
      return $this->memberno;
}
public function getpoststat() {
   
      return $this->poststat;
}



}
?>