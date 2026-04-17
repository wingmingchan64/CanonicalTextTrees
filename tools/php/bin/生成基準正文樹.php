<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\生成基準正文樹.php
*/
require_once(
	dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );
require_once( 
	dirname( __DIR__, 1 ) . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 'functions.php' );
$work_id = 'MENGZI';
$folder = get_folder( $work_id );
$title = get_title( $work_id );
$display_title = get_display_title( $work_id );
//$篇 = $_GET[ 'pian' ];
$篇 = '07';

$txt = file_get_contents( 
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR . 
	$title . DIRECTORY_SEPARATOR . 
	'canonical_text' . DIRECTORY_SEPARATOR . $篇 . '.txt' );
$tree = build_ct_tree( $txt );

$path = dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	$title . DIRECTORY_SEPARATOR . 
	'trees' . DIRECTORY_SEPARATOR . $篇 . '.json';
file_put_contents(
	$path,
	json_encode(
		array( $篇 => $tree ), 
		JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);
?>