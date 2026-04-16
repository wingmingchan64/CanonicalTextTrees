<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\生成句路徑.php
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

$句_坐標 = array();

for( $i = 1; $i <= $num_of_chapters; $i++ )
{
	// change pad number!!!
	$篇 = str_pad( $i, 2, '0', STR_PAD_LEFT );
	//$篇 = '09'; // LUNYU,09,31,64,7
	$path = dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
		$title . DIRECTORY_SEPARATOR .
		'trees' . DIRECTORY_SEPARATOR .
		$篇 . '.json';

	$tree = json_decode( 
		file_get_contents( $path ), true );[ $篇 ];
		
	$prefix = $work_id;
		
	foreach( $tree as $k => $v )
	{
		$prefix .= ',' . key( $tree );
		
		if( is_string( $v ) )
		{
			continue;
		}
		else
		{
			save_path( 
				$prefix, $tree[ $k ] );
		}
	}
}
//print_r( count( $句_坐標 ) );
$path = dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
		$title . DIRECTORY_SEPARATOR .
		'coordinates' . DIRECTORY_SEPARATOR .
		'segments_paths.json';
		
file_put_contents(
	$path,
	json_encode(
		$句_坐標, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

function save_path(
	string $prefix,
	array &$tree ) : void
{
	global $句_坐標;
	
	//$keys = array_keys( $tree );
	//$values = array_values( $tree );
	
	if( is_string( $tree[ array_key_last( $tree ) ] ) )
	{
		//$last_key = array_key_last( $tree );
		//$tree[ $last_key ] .= $punc;
		//echo key( $tree ), NL;
		$句 = implode( $tree );
		
		if( !array_key_exists( $句, $句_坐標 ) )
		{
			$句_坐標[ $句 ] = array();
		}
		
		$句_坐標[ $句 ][] = $prefix;
		
		return;
	}
	elseif( is_array( $tree[ array_key_last( $tree ) ] ) )
	{
		foreach( $tree as $key => $value )
		{
			if( $key == 篇名 )
			{
				continue;
			}
			save_path( $prefix . ',' . $key, $tree[ $key ] );
		}
	}
}
?>