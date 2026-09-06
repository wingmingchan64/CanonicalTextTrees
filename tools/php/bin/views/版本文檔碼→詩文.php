<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\views\版本文檔碼→詩文.php 42 4
*/
require_once(
	dirname( __DIR__, 5 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );
	
check_argv( $argv, 3, "必須提供默文檔碼、版文檔碼" );
$默文檔碼 = fix_doc_id( trim( $argv[ 1 ] ) );
$版文檔碼 = fix_doc_id( trim( $argv[ 2 ] ) );
$著述碼   = 'WANGZHU';
$正文樹   = 提取基準正文樹( $默文檔碼 );
$mm_tree = 提取後設資料樹( $著述碼, $版文檔碼 );
$paths = array();
記錄後設資料樹路徑( $mm_tree );
添加標點符號( $正文樹 );

// replace 詩題
$篇名path = $著述碼 . ',' . $版文檔碼 . ',' . '篇名';
$正文樹[ 詩題 ] = 提取ctt正文( $篇名path );

foreach( $paths as $path )
{
	$parts = explode( '_', $path );
	$默路徑 = explode( ',', $parts[ 3 ] );
	$異文 = 提取ctt正文( $parts[ 4 ] );
	//echo $異文 . ":" . $parts[ 4 ], NL;
	$op = $parts[ 5 ];
	$pointer = &$正文樹;
		
	foreach( $默路徑 as $step )
	{
		$pointer = &$pointer[ $step ];
	}
	
	if( $op == 'replace' )
	{
		$pointer = $異文;
	}
	else // insert
	{
		$pointer .= $異文;
	}
}

echo $正文樹[ $默文檔碼 ][ 詩題 ], NL, NL;
echo 攤平樹文字_略過鍵( $正文樹, array( 詩題 ) );
?>