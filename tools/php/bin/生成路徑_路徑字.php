<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\生成路徑_路徑字.php
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
$num_of_chapters = get_num_of_chapters( $work_id );
$paths = array();
$paths_chars = array();

for( $i = 1; $i <= $num_of_chapters; $i++ )
{
	$文檔碼 = str_pad( $i, 2, '0', STR_PAD_LEFT );
	
	$path = dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
		$title . DIRECTORY_SEPARATOR .
		'trees' . DIRECTORY_SEPARATOR .
		$文檔碼 . '.json';
	$tree = json_decode( 
		file_get_contents( $path ), true )[ $文檔碼 ];
	record_path( $tree, $文檔碼 );
}
echo count( $paths ), NL;
echo count( $paths_chars ), NL;

$coordinates_path = dirname( __DIR__, 3 ) . 
	DIRECTORY_SEPARATOR .
	$title . DIRECTORY_SEPARATOR .
	'coordinates' . DIRECTORY_SEPARATOR .
	'paths.json';
	
file_put_contents(
	$coordinates_path,
	json_encode(
		$paths, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

$coordinates_path = dirname( __DIR__, 3 ) . 
	DIRECTORY_SEPARATOR .
	$title . DIRECTORY_SEPARATOR .
	'coordinates' . DIRECTORY_SEPARATOR .
	'paths_chars.json';
	
file_put_contents(
	$coordinates_path,
	json_encode(
		$paths_chars, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

$result = is_legal_path( $work_id, "01,1,3,2,3" );
	
function record_path( array $tree, string $path ) : void
{
	global $paths;
	global $paths_chars;
	
	if( !in_array( $path, $paths ) )
	{
		$paths[] = $path;
	}
	
	foreach( $tree as $k => $v )
	{
		if( is_string( $v ) )
		{
			if( !in_array( $path . ',' . $k, $paths ) )
			{
				$paths[] = $path . ',' . $k;
			}
			$paths_chars[ $path . ',' . $k ] = $v;
			continue;
		}
		else
		{
			if( !in_array( $path . ',' . $k, $paths ) )
			{
				$paths[] = $path . ',' . $k;
			}
			record_path( $tree[ $k ], $path . ',' . $k );
		}
	}
}
?>