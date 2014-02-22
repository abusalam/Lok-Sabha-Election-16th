<?php

class pp {
private $forasm;
private $forpc;
private $groupid;
private $officecd;
private $poststat;
private $booked;
private $perscd;
private $asmt;
private $asmp;
private $asmo;
private $selected;

function __construct($perscd,$forasm,$forpc,$groupid,$officecd,$poststat,$booked,$asmt,$asmh,$asmo) {
$this->forasm=$forasm;
$this->forpc=$forpc;
$this->groupid=$groupid;
$this->perscd=$perscd;
$this->officecd=$officecd;
$this->poststat=$poststat;
$this->booked=$booked;
$this->asmt=$asmt;
$this->asmh=$asmh;
$this->asmo=$asmo;

}
public function getforasm() {
   
      return $this->forasm;
}
public function getperscd() {
   
      return $this->perscd;
}
public function getforpc() {
   
      return $this->forpc;
}
public function getgroupid() {
   
      return $this->groupid;
}
public function getofficecd() {
   
      return $this->officecd;
}
public function getpoststat() {
   
      return $this->poststat;
}
public function getbooked() {
   
      return $this->booked;
}
public function getasmt() {
   
      return $this->asmt;
}
public function getasmh() {
   
      return $this->asmh;
}
public function getasmo() {
   
      return $this->asmo;
}
public function setbooked($booked) {
   
      $this->booked=$booked;
}
public function setgroupid($groupid) {
   
      $this->groupid=$groupid;
}

public function setfasm($fasm) {
   
      $this->forasm=$fasm;
}
public function setpc($fpc) {
   
      $this->forpc=$fpc;
}public function setsel($sel) {
   
      $this->selected=$sel;
}

}