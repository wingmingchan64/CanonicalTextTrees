<?php
/*
php H:\github\CanonicalTextTrees\tools\php\test_add_punctuation.php
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

$篇 = '02';
$path = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	'論語' . DIRECTORY_SEPARATOR .
	'trees' . DIRECTORY_SEPARATOR .
	$篇 . '.json';

$tree = json_decode( 
	file_get_contents( $path ), true )[ $篇 ];
	
foreach( $tree as $k => $v )
{
	if( is_string( $v ) )
	{
		$tree[ $k ] = '《' . $v . '》';
		continue;
	}
	else
	{
		add_punctuation( $tree[ $k ] );
	}
}

//print_r( $tree );

$contents = [];

foreach( $tree as $k => $v )
{
	if( is_string( $v ) )
	{
		$contents[] = $tree[ $k ];
	}
	else
	{
		$contents[] = 
			flatten_tree_to_text_skip_keys( $tree[ $k ] ) .
			NL;
	}
}

$path = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	'論語' . DIRECTORY_SEPARATOR .
	'views' . DIRECTORY_SEPARATOR .
	$篇 . '.md';

$txt = '';

for( $i = 0; $i < count( $contents ); $i++ )
{
	if( $i == 0 )
	{
		$txt .= '# ' . $contents[ $i ] . NL . NL;
		$txt .= "此文檔用 PHP 程式，以基準正文樹生成。" . NL . NL;
	}
	else
	{
		$txt .= '## ' . $i . NL . NL;
		$txt .= $contents[ $i ] . NL . NL;
	}
}

file_put_contents( $path, $txt );

$txt = '';

for( $i = 0; $i < count( $contents ); $i++ )
{
	if( $i == 0 )
	{
		$txt = '<text id="' . 
			trim( $contents[ $i ], '《》' ) . '">' . NL;
	}
	else
	{
		$txt .= '<prose id="' . $i . '">';
		$txt .= trim( $contents[ $i ] ) . '</prose>' . NL;
	}
}
$txt .= '</text>';

$path = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	'論語' . DIRECTORY_SEPARATOR .
	'views' . DIRECTORY_SEPARATOR .
	$篇 . '.xml';

file_put_contents( $path, $txt );

?>