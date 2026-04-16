<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\提取路徑正文.php
 */

require_once( 
	dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );

require_once( 
	dirname( __DIR__, 1 ) . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 'functions.php' );

echo retrieve_text_from_canonical_tree( 'LUNYU,03,4,9,1' ), NL;

echo retrieve_text_from_canonical_tree( 'LUNYU,03,4,9,1,3' ), NL;

echo retrieve_text_from_canonical_tree( "LUNYU,14,32,75,4,5" ), NL;
?>
