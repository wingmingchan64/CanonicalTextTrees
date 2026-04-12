<?php
/*
php H:\github\CanonicalTextTrees\tools\php\生成論語樹.php
*/
require_once(
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );

require_once( 'functions.php' );
$title = '論語';
$篇 = '19';

$txt = file_get_contents( 
	dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR . 
	$title . DIRECTORY_SEPARATOR . 
	'canonical_text' . DIRECTORY_SEPARATOR . $篇 . '.txt' );
$tree = build_lunyu_tree( $txt );

$path = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	$title . DIRECTORY_SEPARATOR . 
	'trees' . DIRECTORY_SEPARATOR . $篇 . '.json';
file_put_contents(
	$path,
	json_encode(
		array( $篇 => $tree ), 
		JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);
?>