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

// 50000 Angriffsversuche
for( $i = 0; $i < 50000; $i++ )
{
	$word = $wordlist[ $i ];
	$url = "https://www.dict.cc/?s=${word}";
	$regex1 = '/var c1Arr = new Array\((.+?)\);/';
	$regex2 = '/var c2Arr = new Array\((.+?)\);/';
	$regex3 = '/\(.+?\)/';
	
	try
	{
		$file = file_get_contents( $url );
		$matches1 = array();
		$matches2 = array();
		preg_match_all( $regex1, $file, $matches1 );
		preg_match_all( $regex2, $file, $matches2 );
		$str1 = str_replace( '"', '', $matches1[ 1 ][ 0 ] );
		$str2 = str_replace( '"', '', $matches2[ 1 ][ 0 ] );
		$str_array1 = explode( ',', $str1 );
		$str_array2 = explode( ',', $str2 );
		$temp = array();
		
		for( $j = 0; $j < count( $str_array1 ); $j++ )
		{
			if( $str_array2[ $j ] == $word )
			{
				$temp[] = str_replace( "\\'", '', $str_array1[ $j ] );
			}
			// ignore contents in ()
			elseif( 
				trim( preg_replace( $regex3, '', $str_array1[ $j ] ) ) == $word )
			{
				$temp[] = str_replace( "\\'", '', $str_array1[ $j ] );
			}
		}
		
		if( count( $temp ) == 0 )
		{
			continue;
		}
		
		$output_file = $german_folder . 'wordlist.txt';
		$text = "\"${word}\":\"" . implode( ", ", $temp ) . "\"," . NL;
		// Append the string to the file
		// the program can die any time; therefore it // is better to append the string to the file
		file_put_contents( $output_file, $text, FILE_APPEND | LOCK_EX);
	}
	catch( ErrorException $e )
	{
		//print_r( $e );
		continue;
	}
}
?>