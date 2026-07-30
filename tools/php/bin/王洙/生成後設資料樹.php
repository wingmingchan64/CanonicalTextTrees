<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\王洙\生成後設資料樹.php
*/
use Dufu\Exceptions\ConfirmationFailureException;
use Dufu\Exceptions\InvalidCoordinateException;

require_once( 
	dirname( __DIR__, 5 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );

$著述碼  = 'WANGZHU';
$folder = dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	get_ctt_folder( $著述碼 );
$mapping_file = "默文檔碼_版文檔碼.json";
$map = json_decode(
	file_get_contents( $folder . DIRECTORY_SEPARATOR . $mapping_file ), true );

foreach( $map as $默文檔碼 => $版文檔碼 )
{
	生成後設資料樹( $默文檔碼, $著述碼, $版文檔碼 );
}
?>