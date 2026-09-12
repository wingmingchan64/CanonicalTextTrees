<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\杜臆\生成文檔.php
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
$著述碼 = 'DUYI';
$folder = dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	get_ctt_folder( $著述碼 ) . DIRECTORY_SEPARATOR;
$目錄文檔path = $folder . '目錄.txt';
$contents = file_get_contents( $目錄文檔path );
$lines = explode( NL, $contents );
$counter = 1;

$ct_folder = $folder . 
	'canonical_text' . DIRECTORY_SEPARATOR;

//$默認詩文檔碼_詩題 = 提取數據結構( 默認詩文檔碼_詩題 );

foreach( $lines as $line )
{
	[ $詩題, $slashes, $默文檔碼, $pages ] = explode( ' ', $line );
	$版文檔碼 = $counter;
	$old_name = $ct_folder . $默文檔碼 . '.txt';
	$new_name = $ct_folder . 
		'new' . DIRECTORY_SEPARATOR .
		修復文檔碼( $版文檔碼 ) . '.txt';
	
	if( file_exists( $old_name ) )
	{
		echo "Moving $old_name", NL;
		rename( $old_name, $new_name );
	}
	
	$counter++;
}


/*
file_put_contents(
	$folder . '版文檔碼_版詩碼.json',
	json_encode(
		$版本文檔碼_版本詩碼, JSON_UNESCAPED_UNICODE ) );
*/
?>