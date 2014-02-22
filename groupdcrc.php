<?php

class groupdcrc {
private $grpid;
private $dcrc;
function __construct($grpid,$dcrc) {
$this->grpid=$grpid;
$this->dcrc=$dcrc;

}
public function getgrpid() {
   
      return $this->grpid;
}
public function getdcrc() {
   
      return $this->dcrc;
}


}