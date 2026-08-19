<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\harry_potter\生成正文樹、詞典.php 1.01
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
	 
$著述碼 = 'HARRY_POTTER';
$folder = dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	get_ctt_folder( $著述碼 ) . DIRECTORY_SEPARATOR;
$trees_folder = $folder . 'trees' . DIRECTORY_SEPARATOR;
$views_folder = $folder . 'views' . DIRECTORY_SEPARATOR;

check_argv( $argv, 2, "Must provide the doc_id." );
$doc_id = trim( $argv[ 1 ] );
$switches = [
	'pronunciation',
	'grammar',
	//'Cambridge',
	//'Langenscheidt',
	'DE_EN',
	//'Google'
];

$de_filename = $doc_id . '_DE';
$de_file = $trees_folder . $de_filename . '.json';
$en_filename = $doc_id . '_EN';
$en_file = $trees_folder . $en_filename . '.json';

if( file_exists( $de_file ) )
{
	$de_tree = 
		json_decode(
			file_get_contents( $de_file ), true );
}

if( file_exists( $en_file ) )
{
	$en_tree = 
		json_decode(
			file_get_contents( $en_file ), true );
}

$樹 = array( $doc_id => array() );

foreach( $de_tree[ $de_filename ] as $k => $v )
{
	if( $k == '篇名' )
	{
		$樹[ $doc_id ][ '篇名' ][ 'DE' ] = 
			$de_tree[ $de_filename ][ '篇名' ];
		$樹[ $doc_id ][ '篇名' ][ 'en' ] = 
			$en_tree[ $en_filename ][ '篇名' ];
	}
	else
	{
		foreach( array_keys( $v ) as $line )
		{
			$樹[ $doc_id ][ $k ][ $line ][ 'DE' ] = 
				$de_tree[ $de_filename ][ $k ][ $line ];
			$樹[ $doc_id ][ $k ][ $line ][ 'en' ] = 
				$en_tree[ $en_filename ][ $k ][ $line ];
		}
	}
}
$metadata = json_decode( 
	file_get_contents( $folder . 'metadata' . 
	DIRECTORY_SEPARATOR . $doc_id . '.json' ), true );

$german_folder = dirname( __DIR__, 4 ) .
	DIRECTORY_SEPARATOR .
	get_ctt_folder( 'GERMAN' ) . DIRECTORY_SEPARATOR;

if( in_array( 'pronunciation', $switches ) )
{
	$pronunciation_file = $german_folder . 	
		'DE_IPA.json';
	$pronunciation = json_decode(
		file_get_contents( $pronunciation_file ), true);
}
if( in_array( 'grammar', $switches ) )
{
	$grammar_file = $german_folder . 'grammar.json';
	$grammar = json_decode(
		file_get_contents( $grammar_file ), true);
}

/*
if( in_array( 'Langenscheidt', $switches ) )
{
	$Langenscheidt_file = $german_folder . 
		'Langenscheidt.json';
	$Langenscheidt = json_decode(
		file_get_contents( $Langenscheidt_file ), true);
}
if( in_array( 'Cambridge', $switches ) )
{
	$Cambridge_file = $german_folder . 'Cambridge.json';
	$Cambridge = json_decode(
		file_get_contents( $Cambridge_file ), true);
}
*/
if( in_array( 'DE_EN', $switches ) )
{
	$wordlist_file = $german_folder . 'DE_EN.json';
	$wordlist = json_decode(
		file_get_contents( $wordlist_file ), true);
}
/*
if( in_array( 'Google', $switches ) )
{
	$google_file = $german_folder . 'google.json';
	$Google = json_decode(
		file_get_contents( $google_file ), true);
}
*/
//print_r( $樹 );

foreach( $metadata as $path => $terms )
{
	$paths = explode( ',', $path );
	$pointer = &$樹;
	
	foreach( $paths as $step )
	{
		$pointer = &$pointer[ $step ];
	}
	
	if( !array_key_exists( 'entry', $pointer ) )
	{
		$pointer[ 'entry' ] = array();
	}
	
	foreach( $terms as $term )
	{
		if( in_array( 'pronunciation', $switches ) &&
			array_key_exists( $term, $pronunciation ) )
		{
			$pointer[ 'entry' ][ $term ][ 'pronunciation' ]
				= $pronunciation[ $term ];
		}
		if( in_array( 'grammar', $switches ) &&
			array_key_exists( $term, $grammar ) )
		{
			$pointer[ 'entry' ][ $term ][ 'grammar' ]
				= $grammar[ $term ];
		}
		/*
		if( in_array( 'Langenscheidt', $switches ) &&
			array_key_exists( $term, $Langenscheidt ) )
		{
			$pointer[ 'entry' ][ $term ][ 'Langenscheidt' ]
				= $Langenscheidt[ $term ];
		}
		
		if( in_array( 'Cambridge', $switches ) &&
			array_key_exists( $term, $Cambridge ) )
		{
			$pointer[ 'entry' ][ $term ][ 'Cambridge' ]
				= $Cambridge[ $term ];
		}
		*/
		if( in_array( 'DE_EN', $switches ) )
		{
			if( array_key_exists( $term, $wordlist ) )
			{
				$pointer[ 'entry' ][ $term ][ 'DE_EN' ]
					= $wordlist[ $term ];
			}
			else
			{
				$counter = 0;

				foreach( array_keys( $wordlist ) as $k )
				{
					$tempk = trim( preg_replace( '/[.+?]/','', $k ) );
					
					if( $tempk != '' &&
						( str_starts_with( 
						$tempk, $term . ' ' ) ||
						str_ends_with( 
						$tempk,  ' ' . $term ) ||
						strpos( $tempk, ' ' . $term . ' ' ) !== false
						) )
					{
						$pointer[ 'entry' ][ $k ][ 'DE_EN' ] = $wordlist[ $k ];
						$counter++;

						if( $counter > 3 )
						{
							break;
						}
					}
				}
			}
		}
	}
}

file_put_contents(
	$views_folder . $doc_id . '_dic.json',
	json_encode(
		$樹, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) );
?>