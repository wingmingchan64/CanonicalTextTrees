<?php
/*
php H:\github\CanonicalTextTrees\tools\php\create_files.php
*/
require_once(
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );
$file_path = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	'《詩經》' . DIRECTORY_SEPARATOR .
	'目錄.txt';
$txt = file_get_contents( $file_path );
$lines = preg_split( '/\R/u', $txt );
$target_folder = dirname( __DIR__, 2 ) . 
	DIRECTORY_SEPARATOR . 
	'《詩經》' . DIRECTORY_SEPARATOR .
	'raw_text' . DIRECTORY_SEPARATOR;

foreach( $lines as $line )
{
	$parts = explode( ' ', $line );
	
	'《詩經》' . DIRECTORY_SEPARATOR .
	'目錄.txt';
	file_put_contents( $target_folder . $parts[ 0 ] . '.txt', '' );
}

?>