<?php
/*
php H:\github\CanonicalTextTrees\tools\php\提取書名正文坐標.php
*/
require_once(
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );
require_once( 
	__DIR__ . DIRECTORY_SEPARATOR .
	'functions.php' );
$work_id = 'LUNYU';
$folder = $registry[ $work_id ][ 'folder' ];
$坐標s = 提取書名正文坐標( $folder, '大宰知我乎' );
//$坐標s = 提取書名正文坐標( $folder, '大少' );
print_r( $坐標s );

function 提取書名正文坐標(
	string $folder,
	string $正文
) : array
{
	// load chars_paths
	$chars_paths_path = dirname( __DIR__, 2 ) .
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
		$path_array[] = $chars_paths[ $char ];
	}
	
	$max_levels = $len;
	for( $level = 0; $level < $max_levels; $level++ )
	
	//for( $m = $len; $m > 0; $m-- )
	{
		$temp_path_array = array();

		foreach( $path_array as $paths )
		{
			$temp = array();
			
			foreach( $paths as $path )
			{
				$parts = explode( ',', $path );
				array_pop( $parts ); // remove last
				$path = implode( ',', $parts );
			
				if( !in_array( $path, $temp ) )
				{
					$temp[] = $path;
					$temp_paths = $path;
				}
			}
			$chars_paths_array[] = $temp;
			$temp_path_array[] = $temp;
		}
		
		$result_array = $chars_paths_array[ 0 ];
		
		for( $i = 1; $i < count( $chars_paths_array ); $i++ )
		{
			$result_array = array_intersect(
				$result_array,
				$chars_paths_array[ $i ] );
		}
		
		if( count( $result_array ) == 0 )
		{
			$chars_paths_array = array();
			$path_array = $temp_path_array;
		}
		else
		{
			return $result_array;
		}
	}
	
	return array( '' );
}
?>