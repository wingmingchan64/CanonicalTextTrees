<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\王洙\生成目錄.php
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
	 
$著述碼 = 'WANGZHU';
$folder = dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	get_ctt_folder( $著述碼 ) . DIRECTORY_SEPARATOR;
$目錄文檔path = $folder . '目錄.txt';
$contents = file_get_contents( $目錄文檔path );
$lines = explode( NL, $contents );

$默認文檔碼_版本文檔碼 = array();
$默認詩碼_版本詩碼    = array();
$版本文檔碼_默認文檔碼 = array();
$版本文檔碼_版本詩碼   = array();
$版本詩碼_默認詩碼    = array();
$目錄 = array();

foreach( $lines as $line )
{
	$條 = array();
	
	[ $題, $頁s ] = explode( ' ', trim( $line ) );
	$parts = explode( ',', $頁s );
	$默認詩碼 = $parts[ 0 ];
	$默認文檔碼 = substr( $默認詩碼, 0, 4 );
	$版本詩碼 = $parts[ 1 ];
	$版本文檔碼 = substr( $版本詩碼, 0, 4 );
	$默認詩碼_版本詩碼[ $默認詩碼 ] = $版本詩碼;
	$版本詩碼_默認詩碼[ $版本詩碼 ] = $默認詩碼;
	
	if( !array_key_exists( $默認文檔碼, $默認文檔碼_版本文檔碼 ) )
	{
		$默認文檔碼_版本文檔碼[ $默認文檔碼 ] = array();
	}
	if( !in_array( $版本文檔碼, $默認文檔碼_版本文檔碼[ $默認文檔碼 ] ) )
	{
		$默認文檔碼_版本文檔碼[ $默認文檔碼 ][] = $版本文檔碼;
	}

	if( !array_key_exists( $版本文檔碼, $版本文檔碼_默認文檔碼 ) )
	{
		$版本文檔碼_默認文檔碼[ $版本文檔碼 ] = array();
	}
	if( !in_array( $默認文檔碼, $版本文檔碼_默認文檔碼[ $版本文檔碼 ] ) )
	{
		$版本文檔碼_默認文檔碼[ $版本文檔碼 ][] = $默認文檔碼;
	}

	if( !array_key_exists( $版本文檔碼, $版本文檔碼_版本詩碼 ) )
	{
		$版本文檔碼_版本詩碼[ $版本文檔碼 ] = array();
	}
	if( !in_array( $版本詩碼, $版本文檔碼_版本詩碼[ $版本文檔碼 ] ) )
	{
		$版本文檔碼_版本詩碼[ $版本文檔碼 ][] = $版本詩碼;
	}
	
	$續 = $parts[ 2 ];
	$國 = $parts[ 3 ];
	$上 = $parts[ 4 ];
	$條[ 詩題 ] = $題;
	$條[ "默詩碼" ] = $默認詩碼;
	$條[ "默詩碼" ] = $默認詩碼;
	$條[ "版詩碼" ] = $版本詩碼;
	$條[ "所在頁" ] = array(
		"國" => array( "電子書" => "${國}" ),
		"上" => array( "電子書" => "${上}" ),
		"續" => array( "電子書" => "${續}" )
	);
	$目錄[] = $條;
}

file_put_contents(
	$folder . '版本目錄.json',
	json_encode(
		$目錄, JSON_UNESCAPED_UNICODE ) );
file_put_contents(
	$folder . '默文檔碼_版文檔碼.json',
	json_encode(
		$默認文檔碼_版本文檔碼, JSON_UNESCAPED_UNICODE ) );
file_put_contents(
	$folder . '版文檔碼_默文檔碼.json',
	json_encode(
		$版本文檔碼_默認文檔碼, JSON_UNESCAPED_UNICODE ) );
		
		
file_put_contents(
	$folder . '默詩碼_版詩碼.json',
	json_encode(
		$默認詩碼_版本詩碼, JSON_UNESCAPED_UNICODE ) );
file_put_contents(
	$folder . '版詩碼_默詩碼.json',
	json_encode(
		$版本詩碼_默認詩碼, JSON_UNESCAPED_UNICODE ) );
file_put_contents(
	$folder . '版文檔碼_版詩碼.json',
	json_encode(
		$版本文檔碼_版本詩碼, JSON_UNESCAPED_UNICODE ) );

?>