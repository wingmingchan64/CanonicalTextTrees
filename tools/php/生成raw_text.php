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

$text_path = dirname( __DIR__, 2 ) .
	DIRECTORY_SEPARATOR .
	'《詩經》' . DIRECTORY_SEPARATOR .
	'raw_text' . DIRECTORY_SEPARATOR;
	
if( !is_dir( $text_path ) )
{
    throw new RuntimeException( 'raw_text 目錄不存在: ' . $excep_dir );
}
$files = scandir( $text_path );
sort( $files, SORT_STRING );

$異體字 = json_decode(
	file_get_contents( '異體字.json', true ) );

foreach( $files as $file )
{
	$path = $text_path . $file;

	if(
		is_file( $path )
		&& preg_match( '/\.txt$/i', $file )
	)
	{
		$contents = file_get_contents( $path  );
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
?>
