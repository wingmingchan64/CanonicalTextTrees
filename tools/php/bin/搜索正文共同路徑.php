<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\搜索正文共同路徑.php
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

$work_id = 'LUNYU';
//$folder = get_folder( $work_id );
//$title = get_title( $work_id );

$坐標s = 搜索正文共同路徑( $work_id, '大宰知我乎' );
print_r( $坐標s );

$坐標s = 搜索正文共同路徑( $work_id, '大少' );
print_r( $坐標s );

$坐標s = 搜索正文共同路徑( $work_id, '納虐' );
print_r( $坐標s );

$坐標s = 搜索正文共同路徑( $work_id, '少納' );
print_r( $坐標s );

$坐標s = 搜索正文共同路徑( $work_id, '少氦' );
print_r( $坐標s );


function 搜索正文共同路徑(
	string $work_id,
	string $正文
) : array
{
	global $registry;
	$folder = get_folder( $work_id );
	$title = get_title( $work_id );

	// load chars_paths
	$chars_paths_path = dirname( __DIR__, 3 ) .
		DIRECTORY_SEPARATOR .
		$folder . DIRECTORY_SEPARATOR .
		'coordinates' . DIRECTORY_SEPARATOR .
		'chars_paths.json';
	$chars_paths = json_decode(
		file_get_contents( $chars_paths_path ), true );
	$chars_paths_array = array();
	$result_array = array();
	$len = mb_strlen( $正文 );
	$path_array = array();
	
	for( $i = 0; $i < $len; $i++ )
	{
		$char = mb_substr( $正文, $i, 1 );
		
		if( !in_array( $char, array_keys( $chars_paths ) ) )
		{
			echo "《${title}》中沒有「${char}」字。", NL;
			return array( '' );;
		}
		
		$path_array[] = $chars_paths[ $char ];
	}
	
	// size of $path_array[ 0 ] is shrinking
	while( count( $path_array[ 0 ] ) )
	{
		$temp_path_array = array();

		foreach( $path_array as $paths )
		{
			$paths = shorten_path( $paths );
			$temp_path_array[] = $paths;
		}
		
		$path_array = $temp_path_array;
		$result_array = $path_array[ 0 ];
		
		for( $i = 1; $i < count( $path_array ); $i++ )
		{
			$result_array = array_intersect(
				$result_array,
				$path_array[ $i ] );
		}
		
		if( count( $result_array ) == 0 )
		{
			continue; // while
		}
		else
		{
			return array_unique( $result_array );
		}
	}
	
	return array( '' );
}

function shorten_path( array $ary ) : array
{
	$temp = array();
	
	foreach( $ary as $path )
	{
		$parts = explode( ',', $path );
		array_pop( $parts ); // remove last
		$path = implode( ',', $parts );
		$temp[] = $path;
	}
	return $temp;
}
?>