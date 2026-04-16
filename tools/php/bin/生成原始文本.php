<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\生成原始文本.php
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
	 
$work_id = 'LUNYU';
$folder = get_folder( $work_id );
$title = get_title( $work_id );
$display_title = get_display_title( $work_id );

$text_path = dirname( __DIR__, 3 ) .
	DIRECTORY_SEPARATOR .
	$folder . DIRECTORY_SEPARATOR .
	'raw_text' . DIRECTORY_SEPARATOR .
	$folder . '.txt';

$contents = file_get_contents( $text_path );
$contents = normalize( $contents );

foreach( $異體字 as $異 => $正 )
{
	$contents = str_replace( $異, $正, $contents );
}

file_put_contents( $text_path, $contents );
?>
