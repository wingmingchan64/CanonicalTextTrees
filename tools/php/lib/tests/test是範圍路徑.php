<?php
/*
php H:\github\CanonicalTextTrees\tools\php\lib\tests\test是範圍路徑.php
 */
require_once( 
	dirname( __DIR__, 5 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );
require_once( 
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 'functions.php' );
$paths = array();

if( is_scoped_path( 'MENGZI,01,1,3-4', $paths, true ) )
//if( is_scoped_path( 'MENGZI,01,1,3-4' ) )
{
	print_r( $paths );
	//echo "true", NL;
}
?>