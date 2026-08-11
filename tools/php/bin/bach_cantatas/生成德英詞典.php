<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\bach_cantatas\生成德英詞典.php
 */
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
	 
$german_folder = dirname( __DIR__, 4 ) .
	DIRECTORY_SEPARATOR .
	get_ctt_folder( 'GERMAN' ) . DIRECTORY_SEPARATOR;
$wordlist = explode( "\r\n",
	file_get_contents( $german_folder . 
	'deutch_1.6million.txt' ) );

for( $i = 0; $i < 10000; $i++ )
{
	$word = $wordlist[ $i ];
	$url = "https://www.dict.cc/?s=${word}";
	$regex = '/var c1Arr = new Array\((.+?)\);/';
	
	try
	{
		$file = file_get_contents( $url );
		$matches = array();
		preg_match_all( $regex, $file, $matches );
		
		$output_file = $german_folder . 'wordlist.txt';
		
		if( $matches[ 1 ][ 0 ] == '' )
		{
			continue;
		}
		$text = "\"${word}\":\"" . trim(
			str_replace( ',', ', ',
				str_replace( '"', '', 
				implode( ',', $matches[ 1 ] ) ) ), ', ' ) . "\",";
		$text .= NL;
		// Append the string to the file
		file_put_contents( $output_file, $text, FILE_APPEND | LOCK_EX);
	}
	catch( ErrorException $e )
	{
		//print_r( $e );
		continue;
	}
}
?>