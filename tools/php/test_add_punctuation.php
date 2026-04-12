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

$path = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	'論語' . DIRECTORY_SEPARATOR .
	'trees' . DIRECTORY_SEPARATOR .
	'02.json';

$tree = json_decode( 
	file_get_contents( $path ), true );
	
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
	'02.md';

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
		$txt = '<text id="' . $contents[ $i ] . '">' . NL;
	}
	else
	{
		$txt .= '<prose id="' . $i . '">';
		$txt .= $contents[ $i ] . '</prose>' . NL;
	}
}
$txt .= '</text>';

$path = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	'論語' . DIRECTORY_SEPARATOR .
	'views' . DIRECTORY_SEPARATOR .
	'02.xml';

file_put_contents( $path, $txt );

function add_punctuation( 
	array &$tree, string $punc='。' ) : void
{
	$keys = array_keys( $tree );
	$values = array_values( $tree );
	
	if( is_string( $values[ 0 ] ) )
	{
		//$pointer = &$tree[ count( $keys ) ];
		//$pointer = $pointer . $punc;
		$last_key = array_key_last( $tree );
		$tree[ $last_key ] .= $punc;
		return;
	}
	
	elseif( is_array( $values[ 0 ] ) )
	{
		foreach( $tree as $key => $value )
		{
			add_punctuation( $tree[ $key ], $punc );
		}
	}
}
?>