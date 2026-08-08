<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\bach_cantatas\生成正文樹.php
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
	 
$著述碼 = 'BACH_CANTATAS';
$folder = dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	get_ctt_folder( $著述碼 ) . DIRECTORY_SEPARATOR;
$trees_folder = $folder . 'trees' . DIRECTORY_SEPARATOR;
$views_folder = $folder . 'views' . DIRECTORY_SEPARATOR;
	
$bwv = '140';
$DE = $bwv . '.json';
$EN1 = $bwv . '_EN1.json';
$ZH1 = $bwv . '_ZH1.json';

$樹 = array( $bwv => array() );

$de_tree = json_decode(
	file_get_contents( $trees_folder . $DE ), true );
$en1_tree = json_decode(
	file_get_contents( $trees_folder . $EN1 ), true );
$zh1_tree = json_decode(
	file_get_contents( $trees_folder . $ZH1 ), true );

foreach( $de_tree[ $bwv ] as $k => $v )
{
	if( $k == '篇名' )
	{
		$樹[ $bwv ][ '篇名' ] = $de_tree[ $bwv ][ '篇名' ];
	}
	else
	{
		foreach( array_keys( $v ) as $line )
		{
			$樹[ $bwv ][ $k ][ $line ] = array(
				'DE' => $de_tree[ $bwv ][ $k ][ $line ],
				'EN1' => $en1_tree[ $bwv . '_EN1' ][ $k ][ $line ],
				'ZH1' => $zh1_tree[ $bwv . '_ZH1' ][ $k ][ $line ]
			);
		}
	}
}

//print_r( $樹 );


file_put_contents(
	$views_folder . $bwv . '.json',
	json_encode(
		$樹, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) );

?>