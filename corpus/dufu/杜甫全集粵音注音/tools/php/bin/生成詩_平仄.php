<?php
/*
Don't run this again. Hand edit the resulting files instead!!!
*/
require_once(
	dirname( __DIR__, 7 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	'函式.php' );
$base_text_dir = 
	dirname( __DIR__, 7 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	SCHEMAS_JSON_BASE_TEXT_DIR;
$平仄_dir =
	dirname( __DIR__, 7 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	SCHEMAS_JSON_平仄_DIR;

$字_平仄 = json_decode(
	file_get_contents(
		dirname( __DIR__, 6 ) . DS . 
		SCHEMAS_JSON_CANTONESE_DIR .
		字_平仄 . '.json' ), true );

$tree = json_decode(
	file_get_contents( $base_text_dir . '0003.json' ),
	true );
	
樹字_平仄( $tree );

if( !is_dir( $base_text_dir ) )
{
    throw new RuntimeException( '函式目錄不存在: ' . $func_dir );
}
$files = scandir( $base_text_dir );
sort( $files, SORT_STRING );

foreach( $files as $file )
{
	$path = $base_text_dir . $file;

	if(
		is_file( $path )
		&& preg_match( '/\.json$/i', $file )
	)
	{
		if( intval( mb_substr( $file, 0, 4 ) ) )
		{
			$tree = json_decode(
				file_get_contents( $path ), true );
			
			樹字_平仄( $tree );
			
			$json = json_encode(
				$tree,
				JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
			);

			file_put_contents(
				$平仄_dir .
				$file,
				$json . PHP_EOL );

		}
	}
}

function 樹字_平仄( array &$樹 ) : void
{
	global $字_平仄;
	
	foreach( $樹 as $k => $v )
	{
		if( is_string( $v ) )
		{
			if( $v != '' && mb_strlen( $v ) == 1 )
			{
				$樹[ $k ] = $字_平仄[ $v ];
			}
		}
		elseif( is_array( $v ) )
		{
			樹字_平仄( $樹[ $k ] ); // pass in $樹!!!
		}
	}
}

?>