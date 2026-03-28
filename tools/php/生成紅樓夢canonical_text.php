<?php
/*
php H:\github\QuanTangShi\tools\php\生成紅樓夢canonical_text.php
 */
require_once( 
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );

$text_path = dirname( __DIR__, 2 ) .
	DIRECTORY_SEPARATOR .
	'《紅樓夢》' . DIRECTORY_SEPARATOR .
	'canonical_text' . DIRECTORY_SEPARATOR;
$回 = '001';
$file_path = $text_path . $回 . '.txt';
 
$contents = file_get_contents( $file_path  );
$contents = normalize( $contents );
$異體字 = json_decode(
	file_get_contents( '異體字.json', true ) );

foreach( $異體字 as $異 => $正 )
{
	$contents = str_replace( $異, $正, $contents );
}

$contents = preg_replace( '/【\X+?】/u', '', $contents );

file_put_contents( $file_path, $contents );
?>
