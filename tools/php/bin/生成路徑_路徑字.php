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
	 
$work_id = 'SHIJING';

$folder = get_folder( $work_id );
$title = get_title( $work_id );
$display_title = get_display_title( $work_id );
$paths = array();
$paths_chars = array();

$book_tree_dir = dirname( __DIR__, 3 ) . 
	DIRECTORY_SEPARATOR .
	$title . DIRECTORY_SEPARATOR .
	'trees' . DIRECTORY_SEPARATOR;

if( !is_dir( $book_tree_dir ) )
{
    throw new RuntimeException( '樹文件夾不存在: ' . $book_tree_dir );
}
$files = scandir( $book_tree_dir );
sort( $files, SORT_STRING );

foreach( $files as $file )
{
	$path = $book_tree_dir . $file;
	//echo $path, NL;

	if(
		is_file( $path )
		&& preg_match( '/\.json$/i', $file )
	)
	{
		$文檔碼 = str_replace( '.json', '', $file );
		$tree = json_decode(
			file_get_contents( $path ), true )[ $文檔碼 ];
		record_path( $tree, $work_id . ',' . $文檔碼 );
	}
}

for( $i = 1; $i <= $num_of_chapters; $i++ )
{
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