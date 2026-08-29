<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\bach_cantatas\生成法英詞典.php
 */
ini_set('memory_limit', '-1'); 

set_error_handler(function($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        // This statement respects the @ symbol suppression
        return false;
    }
    // Convert the warning into an ErrorException
    throw new ErrorException($message, 0, $severity, $file, $line);
});
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
	 
$french_folder = dirname( __DIR__, 4 ) .
	DIRECTORY_SEPARATOR .
	get_ctt_folder( 'FRENCH' ) . DIRECTORY_SEPARATOR;

$dict_text_file = $french_folder . 'dict.cc.txt';
$contents = file_get_contents( $dict_text_file );
$lines = explode( "\n", $contents );
//echo count( $lines ), NL; // 1313232
$n_pos = array();
$term_en = array();
$FR_noun_gender_number = array();
$FR_EN = array();

foreach( $lines as $line )
{
	if( $line == '' )
	{
		continue;
	}
	$parts = explode( '■', $line );
	
	if( count( $parts ) == 4 && trim( $parts[ 2 ] ) == 'noun' )
	{
		$noun_pos = explode( ' ', trim( $parts[ 0 ] ) );
		$len = count( $noun_pos );
		$pos = '';
		
		// assign the first {X} to pos
		for( $i = 0; $i < $len; $i++ )
		{
			if( strpos( $noun_pos[ $i ], '{' ) !== false )
			{
				$pos = $noun_pos[ $i ];
				unset( $noun_pos[ $i ] );
				break;
			}
		}
		
		// assign the remaining to noun
		$noun = implode( ' ', $noun_pos );
		
		if( !array_key_exists( $noun, $n_pos ) )
		{
			$n_pos[ $noun ] = array();
		}
		
		if( $pos != '' )
		{
			$n_pos[ $noun ][] = $pos;
		}
		
		if( !array_key_exists( $noun, $term_en ) )
		{
			$term_en[ $noun ] = array();
		}
		
		$term_en[ $noun ][] = $parts[ 1 ];
	} // nouns
	else
	{
		if( !array_key_exists( $parts[ 0 ], $term_en ) )
		{
			$term_en[ $parts[ 0 ] ] = array();
		}
		
		if( count( $parts ) >= 2 )
		{
			$term_en[ $parts[ 0 ] ][] = $parts[ 1 ];
		}
	} // others
}

foreach( $n_pos as $k => $v )
{
	$FR_noun_gender_number[ $k ] = implode( ',', 
		array_unique( $v ) );
}

foreach( $term_en as $k => $v )
{
	$FR_EN[ $k ] = implode( ', ', $v );
}

file_put_contents(
	$french_folder . 'FR_noun_gender_number.json',
	json_encode(
		$FR_noun_gender_number, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) );
file_put_contents(
	$french_folder . 'FR_EN.json',
	json_encode(
		$FR_EN, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) );

?>