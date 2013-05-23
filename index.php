<?php

$train = array(toSeconds('24:07:04'));
$headway_secs = 900;

foreach ($train as $key => $value) {
	echo secondsToTime($value+$headway_secs);
}

//http://stackoverflow.com/questions/6019525/php-add-up-hours-minutes-seconds
function toSeconds($string){
	$parts = explode(':', $string);

	$seconds = ($parts[0] * 60 * 60) + ($parts[1] * 60) + $parts[2];

	return $seconds;
}

//http://stackoverflow.com/questions/13559451/php-datetime-display-a-length-of-time-greater-than-24-hours-but-not-as-days-i
function secondsToTime($sec){
    $s=$sec % 60;
    $m=(($sec-$s) / 60) % 60;
    $h=floor($sec / 3600);
    return $h.":".substr("0".$m,-2).":".substr("0".$s,-2);
}

?>