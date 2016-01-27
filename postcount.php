<?php

class postcount {
private $pst;
private $pstL;
private $pstM;

function __construct($pst,$pstL,$pstM) {
$this->pst=$pst;
$this->pstL=$pstL;
$this->pstM=$pstM;

}
public function getpst() {
   
      return $this->pst;
}
public function getpstL() {
   
      return $this->pstL;
}
public function getpstm() {
   
      return $this->pstM;
}


}