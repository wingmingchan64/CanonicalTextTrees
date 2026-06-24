<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\metadata\截取子樹.php
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
$著述碼   = 'JINGQUAN';
$版文檔碼 = '0141';
$paths = array();
$子樹 = 截取子樹( $著述碼, $版文檔碼, array( "注釋", "評論" ) );
記錄後設資料樹路徑( $子樹 );
//print_r( $paths );

$folder = 提取ctt文件夾( $著述碼 );
$樹 = 挂樹飾( $默文檔碼, "${著述碼},${版文檔碼}", $paths );


$著述碼   = 'CHOUZHU';
$版文檔碼 = '0145';
$paths = array();
$子樹 = 截取子樹( $著述碼, $版文檔碼, array( "注釋" ) );
記錄後設資料樹路徑( $子樹 );
//print_r( $paths );

$folder = 提取ctt文件夾( $著述碼 );
$樹 = 挂樹飾( $默文檔碼, "${著述碼},${版文檔碼}", $paths, $樹 );


print_r( $樹 );


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