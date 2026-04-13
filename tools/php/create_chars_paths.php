<?php
/*
php H:\github\CanonicalTextTrees\tools\php\create_chars_paths.php
 */

require_once( 
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );
require_once( 
	__DIR__ . DIRECTORY_SEPARATOR .
	 'functions.php' );

$paths_chars = json_decode(
	file_get_contents(
		dirname( __FILE__, 3 ) . DIRECTORY_SEPARATOR .
		'論語' . DIRECTORY_SEPARATOR .
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
		dirname( __FILE__, 3 ) . DIRECTORY_SEPARATOR .
		'論語' . DIRECTORY_SEPARATOR .
		'coordinates' . DIRECTORY_SEPARATOR .
		'paths_chars.json' ), true );

$chars_paths_path = dirname( __FILE__, 3 ) . 	
	DIRECTORY_SEPARATOR .
	'論語' . DIRECTORY_SEPARATOR .
	'coordinates' . DIRECTORY_SEPARATOR .
	'chars_paths.json';

file_put_contents(
	$chars_paths_path,
	json_encode(
		$chars_paths, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

?>