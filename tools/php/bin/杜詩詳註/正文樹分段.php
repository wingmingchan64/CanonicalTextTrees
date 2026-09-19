<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\杜詩詳註\正文樹分段.php
 */
require_once(
	dirname( __DIR__, 5 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );
require_once( 
	dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 'functions.php' );
	 
$著述碼 = 'CHOUZHU';
$默文檔碼 = '0943';
$版文檔碼 = '0145';
$folder = dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	get_ctt_folder( $著述碼 ) . DIRECTORY_SEPARATOR;

$版正文樹 = json_decode(
	file_get_contents( $folder . 
	'views' . DIRECTORY_SEPARATOR .
	$版文檔碼 . '.json' ), true );

$paragraph_map = json_decode(
	file_get_contents( $folder . 
	'paragraph_mapping' . DIRECTORY_SEPARATOR .
	$版文檔碼 . '.json' ), true );
//print_r( $版正文樹 );
//print_r( $paragraph_map );
$temp = array();

foreach( $版正文樹[ $默文檔碼 ] as $k => $v )
{
	if( intval( $k ) === 0 )
	{
		$temp[ $k ] = $v;
	}
	else
	{
		$line_num = intval( $k );
		
		foreach( $paragraph_map as 
			$para_num => [ $min, $max ] )
		{
			if( !array_key_exists( $para_num, $temp ) )
			{
				$temp[ $para_num ] = array();
			}
			
			if( in_array( 
				$line_num, range( $min, $max ) ) )
			{
				$temp[ $para_num ][ $k ] = $v;
				break;
			}
		}
	}
	continue;
}
$版正文樹[ $默文檔碼 ] = $temp;
//print_r( $版正文樹 );

$json = json_encode(
    $版正文樹,
    JSON_UNESCAPED_UNICODE //| JSON_PRETTY_PRINT
);
file_put_contents(
	$folder . 
	'views' . DIRECTORY_SEPARATOR .
	$版文檔碼 . '分段.json',
	$json . PHP_EOL );



?>