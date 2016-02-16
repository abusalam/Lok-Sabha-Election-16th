<?php

class ps {
private $psn;
private $psf;

function __construct($psn,$psf) {
$this->psn=$psn;
$this->psf=$psf;

}
public function getpsno() {
   
      return $this->psn;
}
public function getpsfix() {
   
      return $this->psf;
}

}