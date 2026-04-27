<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\生成字路徑.php
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
	 
//$work_id = 'LAOZI';
$folder = get_ctt_folder( $work_id );
$title = get_ctt_title( $work_id );
$display_title = get_ctt_display_title( $work_id );

$paths_chars = json_decode(
	file_get_contents(
		dirname( __FILE__, 4 ) . DIRECTORY_SEPARATOR .
		$folder . DIRECTORY_SEPARATOR .
		'coordinates' . DIRECTORY_SEPARATOR .
		'paths_chars.json' ), true );

$chars_paths = array();

foreach( $paths_chars as $path => $char )
{
	if( !array_key_exists( $char, $chars_paths ) )
	{
		$chars_paths[ $char ] = array();
	}
	$chars_paths[ $char ][] = $path;
}

//print_r( $chars_paths );

$paths_chars = json_decode(
	file_get_contents(
		dirname( __FILE__, 4 ) . DIRECTORY_SEPARATOR .
		$title . DIRECTORY_SEPARATOR .
		'coordinates' . DIRECTORY_SEPARATOR .
		'paths_chars.json' ), true );

$chars_paths_path = dirname( __FILE__, 4 ) . 	
	DIRECTORY_SEPARATOR .
	$title . DIRECTORY_SEPARATOR .
	'coordinates' . DIRECTORY_SEPARATOR .
	'chars_paths.json';

file_put_contents(
	$chars_paths_path,
	json_encode(
		$chars_paths, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

?>