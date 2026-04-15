<?php
/*
php H:\github\CanonicalTextTrees\tools\php\生成路徑.php
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
$paths = array();
$paths_chars = array();
$folder = get_folder( $work_id );
$title = get_title( $work_id );

for( $i = 1; $i < 4; $i++ )
{
	$文檔碼 = str_pad( $i, 2, '0', STR_PAD_LEFT );
	$path = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
		$title . DIRECTORY_SEPARATOR .
		'trees' . DIRECTORY_SEPARATOR .
		$文檔碼 . '.json';
	$tree = json_decode(
		file_get_contents( $path ), true )[ $文檔碼 ];
	record_path( $tree, $work_id . ',' . $文檔碼 );
}
// 論語：21147，15945
// 孟子：
echo count( $paths ), NL; // 21147
echo count( $paths_chars ), NL; // 15945

$coordinates_path = dirname( __DIR__, 2 ) . 
	DIRECTORY_SEPARATOR .
	$title . DIRECTORY_SEPARATOR .
	'coordinates' . DIRECTORY_SEPARATOR .
	'paths.json';
	
file_put_contents(
	$coordinates_path,
	json_encode(
		$paths, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

$coordinates_path = dirname( __DIR__, 2 ) . 
	DIRECTORY_SEPARATOR .
	$title . DIRECTORY_SEPARATOR .
	'coordinates' . DIRECTORY_SEPARATOR .
	'paths_chars.json';
	
file_put_contents(
	$coordinates_path,
	json_encode(
		$paths_chars, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

	
function record_path( 
	array $tree, string $path ) : void
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