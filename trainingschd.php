<?php

class trainingschd {
private $schd;
private $type;
private $ven;
private $pst;
private $np;
private $nu;
private $chtp;
private $charea;

function __construct($schd,$type,$ven,$pst,$np,$nu,$chtp, $charea) {


$this->schd=$schd;
$this->type=$type;
$this->ven=$ven;
$this->pst=$pst;
$this->np=$np;
$this->nu=$nu;
$this->chtp=$chtp;
$this->charea=$charea;

}
public function getschd() {
   
      return $this->schd;
}
public function gettype() {
   
      return $this->type;
}

public function getven() {
   
      return $this->ven;
}
public function getpst() {
   
      return $this->pst;
}
public function getnp() {
   
      return $this->np;
}

public function getnu() {
   
      return $this->nu;
}
public function getchtp() {
   
      return $this->chtp;
}
public function getcharea() {
   
      return $this->charea;
}
public function setnu($nu) {
   
      $this->nu=$nu;
}


}
?>