<?php
/*
php H:\github\CanonicalTextTrees\tools\php\清除李善注.php
 */

require_once( 
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );
require_once( 
	dirname( __DIR__, 1 ) . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 'functions.php' );

$work_id = 'WENXUAN';
$folder = get_folder( $work_id );

$filename = '26.31';
$filepath = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	$folder . DIRECTORY_SEPARATOR .
	'raw_text' . DIRECTORY_SEPARATOR .
	$filename . '.txt';
$ptn = '/〈\X+?〉/u';
$contents = file_get_contents( $filepath );
$contents = preg_replace( $ptn, '', $contents );
file_put_contents( $filepath, $contents );
?>