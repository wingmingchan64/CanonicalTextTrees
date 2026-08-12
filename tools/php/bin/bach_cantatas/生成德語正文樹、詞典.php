<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\bach_cantatas\生成德語正文樹、詞典.php 244
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

check_argv( $argv, 2, "Must provide the BWV." );
$bwv = trim( $argv[ 1 ] );

//$bwv = '244';


$de_filename = $bwv . '_DE';
$de_file = $trees_folder . $de_filename . '.json';
$en1_filename = $bwv . '_EN1';
$en1_file = $trees_folder . $en1_filename . '.json';

if( file_exists( $de_file ) )
{
	$de_tree = 
		json_decode(
			file_get_contents( $de_file ), true );
}

if( file_exists( $en1_file ) )
{
	$en1_tree = 
		json_decode(
			file_get_contents( $en1_file ), true );
}

$樹 = array( $bwv => array() );

foreach( $de_tree[ $de_filename ] as $k => $v )
{
	if( $k == '篇名' )
	{
		$樹[ $bwv ][ '篇名' ][ 'DE' ] = 
			$de_tree[ $de_filename ][ '篇名' ];
		$樹[ $bwv ][ '篇名' ][ 'EN1' ] = 
			$en1_tree[ $en1_filename ][ '篇名' ];
	}
	else
	{
		foreach( array_keys( $v ) as $line )
		{
			$樹[ $bwv ][ $k ][ $line ][ 'DE' ] = 
				$de_tree[ $de_filename ][ $k ][ $line ];
			$樹[ $bwv ][ $k ][ $line ][ 'EN1' ] = 
				$en1_tree[ $en1_filename ][ $k ][ $line ];
		}
	}
}

$metadata = json_decode( 
	file_get_contents( $folder . 'metadata' . 
	DIRECTORY_SEPARATOR . $bwv . '.json' ), true );

$german_folder = dirname( __DIR__, 4 ) .
	DIRECTORY_SEPARATOR .
	get_ctt_folder( 'GERMAN' ) . DIRECTORY_SEPARATOR;
$pronunciation_file = $german_folder . 'pronunciation.json';
$pronunciation = json_decode(
	file_get_contents( $pronunciation_file ), true);
$grammar_file = $german_folder . 'grammar.json';
$grammar = json_decode(
	file_get_contents( $grammar_file ), true);
$Langenscheidt_file = $german_folder . 'Langenscheidt.json';
$Langenscheidt = json_decode(
	file_get_contents( $Langenscheidt_file ), true);
$Cambridge_file = $german_folder . 'Cambridge.json';
$Cambridge = json_decode(
	file_get_contents( $Cambridge_file ), true);
$wordlist_file = $german_folder . 'DE_EN.json';
$wordlist = json_decode(
	file_get_contents( $wordlist_file ), true);

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
		if( !array_key_exists( $term, $pointer[ 'entry' ] ) )
		{
			echo $term, NL;
			$pointer[ 'entry' ][ $term ] = array();
		}
		if( array_key_exists( $term, $pronunciation ) )
		{
			$pointer[ 'entry' ][ $term ][ 'pronunciation' ]
				= $pronunciation[ $term ];
		}
		if( array_key_exists( $term, $grammar ) )
		{
			$pointer[ 'entry' ][ $term ][ 'grammar' ]
				= $grammar[ $term ];
		}
		if( array_key_exists( $term, $Langenscheidt ) )
		{
			$pointer[ 'entry' ][ $term ][ 'Langenscheidt' ]
				= $Langenscheidt[ $term ];
		}
		if( array_key_exists( $term, $Cambridge ) )
		{
			$pointer[ 'entry' ][ $term ][ 'Cambridge' ]
				= $Cambridge[ $term ];
		}
		if( array_key_exists( $term, $wordlist ) )
		{
			$pointer[ 'entry' ][ $term ][ 'DE_EN' ]
				= $wordlist[ $term ];
		}
	}
}

file_put_contents(
	$views_folder . $bwv . '_dic.json',
	json_encode(
		$樹, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) );
?>