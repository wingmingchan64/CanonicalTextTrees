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
$languages = array( 'DE' , 'EN1', 'ZH1', 'FR1' );
$lang_trees = array();

foreach( $languages as $lang )
{
	$file = $trees_folder . $bwv . '_' . $lang . '.json';
	
	if( file_exists( $file ) )
	{
		$lang_trees[ $lang ] = 
			json_decode(
				file_get_contents( $file ), true );
	}
}

$樹 = array( $bwv => array() );

foreach( $lang_trees[ $languages[ 0 ] ]
	[ $bwv.'_'.$languages[ 0 ] ] as $k => $v )
{
	if( $k == '篇名' )
	{
		foreach( $languages as $l )
		{
			$樹[ $bwv ][ '篇名' ][ $l ] = $lang_trees[ $l ][ $bwv.'_'.$l ][ '篇名' ];
		}
	}
	else
	{
		foreach( array_keys( $v ) as $line )
		{
			foreach( $lang_trees as $l => $l_tree )
			{
				$樹[ $bwv ][ $k ][ $line ][ $l ] = 
					$lang_trees[ $l ][ $bwv . '_' . $l ][ $k ][ $line ];
				
			}
		}
	}
}

//print_r( $樹 );


file_put_contents(
	$views_folder . $bwv . /*'_ZH1_FR1' .*/ '.json',
	json_encode(
		$樹, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) );

?>