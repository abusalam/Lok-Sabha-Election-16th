<?php
function clean_spl($string) {
   //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
  // return preg_replace('/[^A-Za-z0-9\-.,+&()]/', '', $string); // Removes special chars.
   return preg_replace('/[^^a-zA-Z0-9#@:_(),.!@"\/ ]/', '', $string); 
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

function redirect($url){
if (headers_sent()){
  die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
}else{
  header('Location: ' . $url);
  die();
}    
}

function wordcase($string)
{
	return ucwords(strtolower($string));
}
function uppercase($string) {
	return strtoupper($string);
}
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'Zero',
        1                   => 'First',
        2                   => 'Second',
        3                   => 'Third',
        4                   => 'Fourth',
        5                   => 'Fifth',
        6                   => 'Sixth',
        7                   => 'Seventh',
        8                   => 'Eighth',
        9                   => 'Nineth',
        10                  => 'Tenth',
        11                  => 'Eleventh',
        12                  => 'Twelveth',
        13                  => 'Thirteenth',
        14                  => 'Fourteenth',
        15                  => 'Fifteenth',
        16                  => 'Sixteenth',
        17                  => 'Seventeenth',
        18                  => 'Eighteenth',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        1000000             => 'Million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}
?>