<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\永明的杜甫集\生成資料匯總樹.php

before this, run
php H:\github\CanonicalTextTrees\tools\php\bin\執行路徑程式.php
php H:\github\Dufu-Analysis\tools\php\bin\views\資料匯總\生成後設資料樹.php
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
$著述碼 = 'YMDDFJ';
$簡稱_著述碼 = 提取數據結構( 簡稱_著述碼 );
$著述碼_簡稱 = 提取數據結構( 著述碼_簡稱 );
$部分 = array( "題解", "注釋" , "評論" );

$樹 = 提取基準正文樹( $默文檔碼 );
$書目簡稱 = 提取數據結構( 書目簡稱 );
$開關 = array();
$參考書目 = array();
添加標點符號( $樹 );
添加錨( $樹 );

$paths = array();
$子樹 = 截取子樹( $著述碼, $默文檔碼, $部分 );
記錄後設資料樹路徑( $子樹 );

foreach( $paths as $path )
{
	$parts = explode( '_', $path );
	$引用著述碼 = explode( ',', $parts[ 4 ] )[ 0 ];
	$parts[ 0 ] = $引用著述碼;
	$path = implode( '_', $parts );
	附加著述資料(
		$默文檔碼, "${引用著述碼},${默文檔碼}", 
		array( $path ), $樹 );

}


$folder = 提取ctt文件夾( $著述碼 );


/*
植入路徑子樹( $樹, array( 樹錨名 ),
	array( '開關' => $開關 ) );

植入路徑子樹( $樹, array( 樹錨名 ),
	array( '參考' => $參考書目 ) );
*/
//print_r( $樹 );

$json = json_encode(
	$樹,
	JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
);

file_put_contents(
	dirname( __DIR__, 5 ) . DIRECTORY_SEPARATOR .
	基準正文樹文件夾 .
	$folder . DIRECTORY_SEPARATOR .
	'views' . DIRECTORY_SEPARATOR .
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