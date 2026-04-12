<?php
/*
php H:\github\CanonicalTextTrees\tools\php\record_paths.php

    [0] => 24
    [1] => 24,49
    [2] => 24,49,1
    [3] => 24,49,1,1
    [4] => 24,49,1,2
    [5] => 24,49,2
    [6] => 24,49,2,1
    [7] => 24,49,2,2
    [8] => 24,49,2,3
    [9] => 24,49,2,4
    [10] => 24,49,2,5
    [11] => 24,49,2,6
    [12] => 24,49,3
    [13] => 24,49,3,1
    [14] => 24,49,3,2
    [15] => 24,49,4
    [16] => 24,49,4,1
    [17] => 24,49,4,2
    [18] => 24,49,4,3
    [19] => 24,49,4,4
    [20] => 24,49,5
    [21] => 24,49,5,1
    [22] => 24,49,5,2
    [23] => 24,49,5,3



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

$文檔碼 = '02';
$path = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	'論語' . DIRECTORY_SEPARATOR .
	'trees' . DIRECTORY_SEPARATOR .
	$文檔碼 . '.json';

$tree = json_decode( 
	file_get_contents( $path ), true );
$paths = array();
record_path( $tree, $文檔碼 );
print_r( $paths );
	
function record_path( array $tree, string $path ) : void
{
	global $paths;
	
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