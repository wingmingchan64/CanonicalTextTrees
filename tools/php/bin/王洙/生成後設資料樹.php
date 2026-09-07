<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\王洙\生成後設資料樹.php 6

When working with more than one 默文檔碼, do not use
chars; use paths instead.
*/
//use Dufu\Exceptions\ConfirmationFailureException;
//use Dufu\Exceptions\InvalidCoordinateException;
use Dufu\Exceptions\DocumentIDNotFoundException;

require_once( 
	dirname( __DIR__, 5 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );

check_argv( $argv, 2, "必須提供版本文檔碼" );
$版文檔碼 = fix_doc_id( trim( $argv[ 1 ] ) );
$著述碼  = 'WANGZHU';
$folder = dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	get_ctt_folder( $著述碼 ) . DIRECTORY_SEPARATOR;
$map = json_decode(
	file_get_contents( $folder . '版文檔碼_默文檔碼.json' ),
	true );

$默文檔碼s = $map[ $版文檔碼 ];

foreach( $默文檔碼s as $默文檔碼 )
{
	if( !是合法文檔碼( $默文檔碼 ) )
	{
		throw new DocumentIDNotFoundException( '無此文檔碼。' );
	}
	生成後設資料樹( $默文檔碼, $著述碼, $版文檔碼 );
}
?>