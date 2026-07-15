<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\metadata\生成資料匯總樹.php

before this, run

*/
//use CTT\Exceptions\IllegalWorkIDException;
//use Dufu\Exceptions\JsonFileNotFoundException;
//use Dufu\Exceptions\InvalidAnchorValueException;

require_once(
	dirname( __DIR__, 5 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );

$默文檔碼 = '0943';
$簡稱_著述碼 = 提取數據結構( 簡稱_著述碼 );
$杜著述s = array(
	array(
		"簡稱"=>"錢",
		"文檔碼"=>"0060",
		"部分"=>array( "注釋" )
		),
	array(
		"簡稱"=>"仇",
		"文檔碼"=>"0145",
		"部分"=>array( "題解","注釋","評論" )
		),
	array(
		"簡稱"=>"楊",
		"文檔碼"=>"0141",
		"部分"=>array( "題解","注釋","評論" )
		),
	array(
		"簡稱"=>"焮",
		"文檔碼"=>"206.13",
		"部分"=>array( "題解","注釋","異文","校記" )
		),
	array(
		"簡稱"=>"蕭",
		"文檔碼"=>"0146",
		"部分"=>array( "題解","注釋","評論","異文","校記" )
		),
	array(
		"簡稱"=>"粵",
		"文檔碼"=>"0943",
		"部分"=>array( "粵音","平仄","韻部" )
		),
	array(
		"簡稱"=>"訳",
		"文檔碼"=>"0188",
		"部分"=>array( "翻譯" )
		),
	array(
		"簡稱"=>"歐",
		"文檔碼"=>"05.27",
		"部分"=>array( "翻譯" )
		),
);

$樹 = null;

foreach( $杜著述s as $杜著述 )
{
	$簡稱 = $杜著述[ "簡稱" ];
	//echo $簡稱, NL;
	$著述碼 = $簡稱_著述碼[ $簡稱 ];
	$版文檔碼 = $杜著述[ "文檔碼" ];
	$部分 = $杜著述[ "部分" ];
	$paths = array();
	$子樹 = 截取子樹( $著述碼, $版文檔碼, $部分 );
	記錄後設資料樹路徑( $子樹 );
	//print_r($paths);
	
	$folder = 提取ctt文件夾( $著述碼 );
	$樹 = 附加著述資料( $默文檔碼, "${著述碼},${版文檔碼}", $paths,	$樹  );
}
//print_r( $樹 );
/*
$著述碼   = 'CHOUZHU';
$版文檔碼 = '0145';
$paths = array();
$子樹 = 截取子樹( $著述碼, $版文檔碼, array( "題解","注釋","大意","評論" ) );
記錄後設資料樹路徑( $子樹 );
//print_r( $paths );

$folder = 提取ctt文件夾( $著述碼 );
$樹 = 挂樹飾( $默文檔碼, "${著述碼},${版文檔碼}", $paths, $樹 );
//print_r( $樹 );
*/

$json = json_encode(
	$樹,
	JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
);

file_put_contents(
	dirname( __DIR__, 4 ) . DS . 
	'corpus' . DS .
	'dufu' . DS .
	'資料匯總' . DS .
	'views' . DS .
	$默文檔碼 . '.json',
	$json . PHP_EOL );




function 截取子樹(
	string $著述碼, string $版文檔碼, array $節點s ) : array
{
	$m_tree = 提取後設資料樹( $著述碼, $版文檔碼 );
	$subtree = $m_tree[ $著述碼 ][ $版文檔碼 ];
	$子樹 = array();
	$子樹[ $著述碼 ][ $版文檔碼 ] = array();
	
	foreach( $節點s as $節點 )
	{
		if( in_array( $節點, array_keys( $subtree ) ) )
		{
			$子樹[ $著述碼 ][ $版文檔碼 ][ $節點 ] =
				$subtree[ $節點 ];
		}
	}
	
	return $子樹;
}
?>