<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\dictionary\retrieve_fr_def.php
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
	 
$conversion_table = array(
	"ç" => "%C3%A7"
);
$term = "manger";
$pattern = '/<meta name="description" content=".+?translate:(.+?)>/';
$match = array();
$url = "https://dictionary.cambridge.org/dictionary/french-english/${term}";
$contents = file_get_contents( $url );
preg_match_all( $pattern, $contents, $match );

$data = $match[ 1 ][ 0 ];
$parts = explode( '.', $data );

if( count( $parts ) > 0 )
{
	$parts = explode( ', ', trim( $parts[ 0 ] ) );
	print_r( array_unique( $parts ) );
}
?>