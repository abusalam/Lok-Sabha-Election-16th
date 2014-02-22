<?php

class assemblyparty {
private $asm;
private $pc;
private $members;
private $partyreqd;
private  $subd;
function __construct($asm,$pc,$members,$partyreqd,$subd) {
$this->asm=$asm;
$this->pc=$pc;
$this->members=$members;
$this->partyreqd=$partyreqd;
$this->subd=$subd;

}
public function getassembly() {
   
      return $this->asm;
}
public function getpc() {
   
      return $this->pc;
}
public function getmember() {
   
      return $this->members;
}
public function getpartyreqd() {
   
      return $this->partyreqd;
}
public function getsub() {
   
      return $this->subd;
}

}