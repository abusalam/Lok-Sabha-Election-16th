<?php
function clean_spl($string) {
   //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\-.,+& ]/', '', $string); // Removes special chars.
}
function clean_alpha($string) {
   //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^0-9\-.,+]/', '', $string); // Removes special chars.
}
function only_num($string) {
   //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^0-9]/', '', $string); // Removes special chars.
}
function encode($string) {
   //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return base64_encode(base64_encode($string));
}
function decode($string) {
   return base64_decode(base64_decode($string));
}
function addOrdinalNumberSuffix($num) {
if (!in_array(($num % 100),array(11,12,13))){
  switch ($num % 10) {
	// Handle 1st, 2nd, 3rd
	case 1:  return $num.'st';
	case 2:  return $num.'nd';
	case 3:  return $num.'rd';
  }
}
return $num.'th';
}
?>