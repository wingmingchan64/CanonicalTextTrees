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
$mapping_file = "默詩碼_版詩碼.json";
$map = json_decode(
	file_get_contents( $folder . DIRECTORY_SEPARATOR . $mapping_file ), true );


foreach( $map as $默詩碼 => $版詩碼 )
{
	if( strlen( $默詩碼 ) != 4 )
	{
		$默文檔碼 = substr( $默詩碼, 0, 4 );
		$版文檔碼 = substr( $版詩碼, 0, 4 );
	}
	else
	{
		$默文檔碼 = $默詩碼;
		$版文檔碼 = $版詩碼;
	}
	// for 組詩, mulitple execution of this line
	生成後設資料樹( $默文檔碼, $著述碼, $版文檔碼 );
}
?>