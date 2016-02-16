<?php

class groupdtl {
private $forasm;
private $forpc;
private $groupid;
private $office1;
private $office2;
private $office3;
private $office4;
private $office5;
private $office6;
//private $office7;

function __construct($forasm,$forpc,$groupid,$office1,$office2,$office3,$office4,$office5,$office6) {
$this->forasm=$forasm;
$this->forpc=$forpc;
$this->groupid=$groupid;
$this->office1=$office1;
$this->office2=$office2;
$this->office3=$office3;
$this->office4=$office4;
$this->office5=$office5;
$this->office6=$office6;

}
public function getforasm() {
   
      return $this->forasm;
}
public function getforpc() {
   
      return $this->forpc;
}
public function getgroupid() {
   
      return $this->groupid;
}
public function getoffice1() {
   
      return $this->office1;
}
public function getoffice2() {
   
      return $this->office2;
}
public function getoffice3() {
   
      return $this->office3;
}
public function getoffice4() {
   
      return $this->office4;
}
public function getoffice5() {
   
      return $this->office5;
}
public function getoffice6() {
   
      return $this->office6;
}
public function setoffice1($off1) {
   
      $this->office1=$off1;
}
public function setoffice2($off2) {
   
      $this->office2=$off2;
}
public function setoffice3($off3) {
   
      $this->office3=$off3;
}
public function setoffice4($off4) {
   
      $this->office4=$off4;
}
public function setoffice5($off5) {
   
      $this->office5=$off5;
}
public function setoffice6($off6) {
   
      $this->office6=$off6;
}
}