<?php
/*
php H:\github\CanonicalTextTrees\corpus\dufu\杜甫全集粵音注音\tools\php\bin\生成字_平仄.php
*/
require_once(
	dirname( __DIR__, 7 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	'函式.php' );
require_once(
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'聲韻調' . DIRECTORY_SEPARATOR .
	'字_韻部.php' );
require_once(
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'聲韻調' . DIRECTORY_SEPARATOR .
	'韻部_平仄.php' );


$字_平仄 = array();
$一字組合_坐標 = 提取數據結構( 一字組合_坐標 );
$字s =  array_keys( $一字組合_坐標 );

foreach( $字s as $字 )
{
	$平聲 = false;
	$仄聲 = false;
	
	foreach( $字_韻部[ $字 ] as $韻部 )
	{
		if( $韻部_平仄[ $韻部 ] == '平' )
		{ $平聲 = true; }
		if( $韻部_平仄[ $韻部 ] == '仄' )
		{ $仄聲 = true; }
	}
	
	if( $平聲 && $仄聲 )
	{
		$符號 = 平仄聲符號;
	}
	elseif( $平聲 )
	{
		$符號 = 平聲符號;
	}
	else
	{
		$符號 = 仄聲符號;
	}
	
	
	$字_平仄[ $字 ] = $符號;
	
	if( !array_key_exists( $字, $字_韻部 ) )
	{
		echo $字, NL;
	}
	
	
}

$json = json_encode(
    $字_平仄,
    JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
);

file_put_contents(
	dirname( __DIR__, 6 ) . DS . 
	SCHEMAS_JSON_CANTONESE_DIR .
	字_平仄 . ".json",
	$json . PHP_EOL );
?>