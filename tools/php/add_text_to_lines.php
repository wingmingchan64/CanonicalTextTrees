<?php
/*
php H:\github\CanonicalTextTrees\tools\php\add_text_to_lines.php
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
//echo $txt;
$lines = preg_split( '/\R/u', $txt );
$contents = '';

$start_num = 303;
$end_num = 311;
$diff = 301;
$what_to_add_front = '20.';

//$what_to_add_back = '';

for( $i = 0; $i < count( $lines ); $i++ )
{
	if( $i < $start_num || $i > $end_num )
	{
		$line = $lines[ $i ] . NL;;
	}
	else
	{
		$line = $what_to_add_front . 
			str_pad( ( $i - $diff ) . '' , 2, '0', STR_PAD_LEFT ) . ' ' .
			$lines[ $i ] . NL;;
		echo $line;
	}
	
	$contents = $contents . $line;
}
file_put_contents( $file_path, $contents );
?>