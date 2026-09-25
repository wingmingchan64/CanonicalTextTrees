<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\project_hail_mary\生成法語正文樹、詞典.php 01
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
	 
$著述碼 = 'PROJECT';
$folder = dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	get_ctt_folder( $著述碼 ) . DIRECTORY_SEPARATOR;
$trees_folder = $folder . 'trees' . DIRECTORY_SEPARATOR;
$views_folder = $folder . 'views' . DIRECTORY_SEPARATOR;

check_argv( $argv, 2, "Must provide the doc id." );
$doc_id = trim( $argv[ 1 ] );
$switches = [
	'pronunciation',
	'Cambridge',
	'LeRobert',
	'FR_EN',
	'Google'
];

$en_filename = $doc_id . '_EN';
$en_file = $trees_folder . $en_filename . '.json';

if( file_exists( $en_file ) )
{
	$en_tree = 
		json_decode(
			file_get_contents( $en_file ), true );
}


$fr_filename = $doc_id . '_FR';
$fr_file = $trees_folder . $fr_filename . '.json';

if( file_exists( $fr_file ) )
{
	$fr_tree = 
		json_decode(
			file_get_contents( $fr_file ), true );
}

$樹 = array( $doc_id => array() );

foreach( $en_tree[ $en_filename ] as $k => $v )
{
	if( $k == '篇名' )
	{
		$樹[ $doc_id ][ '篇名' ][ 'EN' ] = 
			$en_tree[ $en_filename ][ '篇名' ];
		$樹[ $doc_id ][ '篇名' ][ 'FR' ] = 
			$fr_tree[ $fr_filename ][ '篇名' ];
	}
	else
	{
		foreach( array_keys( $v ) as $line )
		{
			$樹[ $doc_id ][ $k ][ $line ][ 'EN' ] = 
				$en_tree[ $en_filename ][ $k ][ $line ];
			$樹[ $doc_id ][ $k ][ $line ][ 'FR' ] = 
				$fr_tree[ $fr_filename ][ $k ][ $line ];
		}
	}
}
//print_r( $樹 );
$metadata = json_decode( 
	file_get_contents( $folder . 'metadata' . 
	DIRECTORY_SEPARATOR . $doc_id . '.json' ), true );

$french_folder = dirname( __DIR__, 4 ) .
	DIRECTORY_SEPARATOR .
	get_ctt_folder( 'FRENCH' ) . DIRECTORY_SEPARATOR;

if( in_array( 'pronunciation', $switches ) )
{
	$pronunciation_file = $french_folder . 	
		//'pronunciation.json';
		'FR_IPA.json';
	$pronunciation = json_decode(
		file_get_contents( $pronunciation_file ), true);
}
/*
if( in_array( 'grammar', $switches ) )
{
	$grammar_file = $german_folder . 'grammar.json';
	$grammar = json_decode(
		file_get_contents( $grammar_file ), true);
}
*/
if( in_array( 'LeRobert', $switches ) )
{
	$LeRobert_file = $french_folder . 
		'LeRobert.json';
	$LeRobert = json_decode(
		file_get_contents( $LeRobert_file ), true);
}

if( in_array( 'Cambridge', $switches ) )
{
	$Cambridge_file = $french_folder . 'Cambridge.json';
	$Cambridge = json_decode(
		file_get_contents( $Cambridge_file ), true);
}

if( in_array( 'FR_EN', $switches ) )
{
	$wordlist_file = $french_folder . 'FR_EN.json';
	$wordlist = json_decode(
		file_get_contents( $wordlist_file ), true);
}

if( in_array( 'Google', $switches ) )
{
	$google_file = $french_folder . 'Google.json';
	$Google = json_decode(
		file_get_contents( $google_file ), true);
}
//print_r( $metadata );

foreach( $metadata as $path => $terms )
{
	$paths = explode( ',', $path );
	$pointer = &$樹;
	
	foreach( $paths as $step )
	{
		$pointer = &$pointer[ $step ];
	}
	
	if( count( $switches ) > 0 &&
		!array_key_exists( 'entry', $pointer ) )
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
		
		if( in_array( 'LeRobert', $switches ) &&
			array_key_exists( $term, $LeRobert ) )
		{
			$pointer[ 'entry' ][ $term ][ 'LeRobert' ]
				= $LeRobert[ $term ];
		}
		
		if( in_array( 'Cambridge', $switches ) &&
			array_key_exists( $term, $Cambridge ) )
		{
			$pointer[ 'entry' ][ $term ][ 'Cambridge' ]
				= $Cambridge[ $term ];
		}
		if( in_array( 'FR_EN', $switches ) )
		{
			if( array_key_exists( $term, $wordlist ) )
			{
				$pointer[ 'entry' ][ $term ][ 'FR_EN' ]
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
						$pointer[ 'entry' ][ $k ][ 'FR_EN' ] = $wordlist[ $k ];
						$counter++;

						if( $counter > 3 )
						{
							break;
						}
					}
				}
			}
		}
		
		if( in_array( 'Google', $switches ) &&
			array_key_exists( $term, $Google ) )
		{
			$pointer[ 'entry' ][ $term ][ 'Google' ]
				= $Google[ $term ];
		}
	}
}

file_put_contents(
	$views_folder . $doc_id . '_dic.json',
	json_encode(
		$樹, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) );
?>