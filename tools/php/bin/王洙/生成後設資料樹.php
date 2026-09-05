<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\王洙\生成後設資料樹.php 276 1

When working with more than one 默文檔碼, do not use
chars; use paths instead.
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

check_argv( $argv, 3, "必須提供默文檔碼、版文檔碼" );
$默文檔碼 = fix_doc_id( trim( $argv[ 1 ] ) );
$版文檔碼 = fix_doc_id( trim( $argv[ 2 ] ) );

$著述碼  = 'WANGZHU';
$folder = dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	get_ctt_folder( $著述碼 );
	
//$mapping_file = "版詩碼_默詩碼.json";
//$map = json_decode(
	//file_get_contents( $folder . DIRECTORY_SEPARATOR . $mapping_file ), true );

// $版詩碼 always 4 digits
//foreach( $map as $版詩碼 => $默詩碼 )
//{
	//if( is_array( $默詩碼 ) ) // 組詩
	//{
		//$默文檔碼 = substr( $默詩碼[ '1' ], 0, 4 );
	//}
	//else
	//{
		//$默文檔碼 = $默詩碼;
	//}
	//$版文檔碼 = $版詩碼;
	生成後設資料樹( $默文檔碼, $著述碼, $版文檔碼 );
//}
?>