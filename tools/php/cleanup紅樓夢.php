<?php
/*
php H:\github\CanonicalTextTrees\tools\php\cleanup紅樓夢.php
 */
require_once( 
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );
require_once( 
	dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 'functions.php' );
$work_id = 'HLM';
$folder = get_folder( $work_id );

$回 = '020';
$text_path = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	$folder . DIRECTORY_SEPARATOR .
	'canonical_text' . DIRECTORY_SEPARATOR .
	$回 . '.txt';

$contents = file_get_contents( $text_path );
$contents = normalize( $contents );
file_put_contents( $text_path, $contents );
?>
