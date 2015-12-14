<?php
function cleanUsername($string) {
	$string = preg_replace( "/[[:punct:]]/", '', $string);
	$string = preg_replace("/[\s]/", '', $string);
	return $string;
}