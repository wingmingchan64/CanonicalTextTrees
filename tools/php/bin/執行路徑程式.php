<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\執行路徑程式.php
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
	 
$work_id = 'HLM';
$folder  = get_folder( $work_id );
$title   = get_title( $work_id );
$trees_dir = dirname( __FILE__, 4 ) . 
	DIRECTORY_SEPARATOR .
	$title . DIRECTORY_SEPARATOR .
	'trees' . DIRECTORY_SEPARATOR;
$coordinates_dir = dirname( __FILE__, 4 ) . 
	DIRECTORY_SEPARATOR .
	$title . DIRECTORY_SEPARATOR .
	'coordinates' . DIRECTORY_SEPARATOR;

if ( !is_dir( $trees_dir ) )
{
	mkdir( $trees_dir, 0777, true );
}
if ( !is_dir( $coordinates_dir ) )
{
	mkdir( $coordinates_dir, 0777, true );
}

//574443
//497404
//require( __DIR__ . DIRECTORY_SEPARATOR . '生成基準正文樹.php' );
//require( __DIR__ . DIRECTORY_SEPARATOR . '生成路徑_路徑字.php' );
require( __DIR__ . DIRECTORY_SEPARATOR . '生成字路徑.php' );
require( __DIR__ . DIRECTORY_SEPARATOR . '生成句路徑.php' );
?>