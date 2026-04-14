<?php
/*
php H:\github\CanonicalTextTrees\tools\php\生成raw_text.php
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
	 
$work_id = 'MENGZI';
$folder = $registry[ $work_id ][ 'folder' ];
$title = $registry[ $work_id ][ 'title' ];

$text_path = dirname( __DIR__, 2 ) .
	DIRECTORY_SEPARATOR .
	$folder . DIRECTORY_SEPARATOR .
	'raw_text' . DIRECTORY_SEPARATOR .
	$folder . '.txt';

$異體字 = json_decode(
	file_get_contents( '異體字.json', true ) );

$contents = file_get_contents( $text_path );
$contents = normalize( $contents );

foreach( $異體字 as $異 => $正 )
{
	$contents = str_replace( $異, $正, $contents );
}

file_put_contents( $text_path, $contents );
/*
foreach( $files as $file )
{
	$path = $text_path . $file;

	if(
		is_file( $path )
		&& preg_match( '/\.txt$/i', $file )
	)
	{
		$contents = file_get_contents( $path );
		$contents = normalize( $contents );

		foreach( $異體字 as $異 => $正 )
		{
			$contents = str_replace( $異, $正, $contents );
		}

		$contents = preg_replace( '/【\X+?】/u', '', $contents );
		$contents = preg_replace( '/〈\X+?〉/u', '', $contents );
		$contents = preg_replace( '/\[\X+?\]/u', '', $contents );

		file_put_contents( $path, $contents );
	}
}
*/
?>
