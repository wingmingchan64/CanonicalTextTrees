<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\views\版本文檔碼→詩文.php 4
*/
use Dufu\Exceptions\DocumentIDNotFoundException;

require_once(
	dirname( __DIR__, 5 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );
	
check_argv( $argv, 2, "必須提供版本文檔碼" );
$版文檔碼 = fix_doc_id( trim( $argv[ 1 ] ) );
$生成md  = true;
$著述碼   = 'WANGZHU';
//$contents = '';
$folder = dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	get_ctt_folder( $著述碼 ) . DIRECTORY_SEPARATOR;
$map = json_decode(
	file_get_contents( $folder . '版文檔碼_版詩碼.json' ),
	true );

$版詩碼s = $map[ $版文檔碼 ];
$是組詩 = count( $版詩碼s ) > 1;
$版詩碼_默詩碼 = json_decode(
	file_get_contents( $folder . '版詩碼_默詩碼.json' ), true );

// 版本詩題
$篇名path = $著述碼 . ',' . $版文檔碼 . ',' . '篇名';
$詩題 = 提取ctt正文( $篇名path );
$詩題contents = $詩題;
$詩文contents = '';
$mm_tree = 提取後設資料樹( $著述碼, $版文檔碼 );
$paths = array();
記錄後設資料樹路徑( $mm_tree );

foreach( $版詩碼s as $版詩碼 )
{
	$默詩碼  = $版詩碼_默詩碼[ $版詩碼 ];
	$默文檔碼 = substr( $默詩碼, 0 , 4 );
		
	if( !是合法文檔碼( $默文檔碼 ) )
	{
		throw new DocumentIDNotFoundException( '無此文檔碼。' );
	}
	
	if( $是組詩 )
	{
		$正文樹 = 提取基準正文樹( $默詩碼 );
		添加標點符號( $正文樹 );
	}
	else
	{
		$正文樹 = 提取基準正文樹( $默文檔碼 );
		添加標點符號( $正文樹 );
	}
	
	foreach( $paths as $path )
	{
		$parts = explode( '_', $path );
		$默路徑 = explode( ',', $parts[ 3 ] );
		$異文 = 提取ctt正文( $parts[ 4 ] );
		$op = $parts[ 5 ];
		$pointer = &$正文樹;
		$path_exist = true;
		
		foreach( $默路徑 as $step )
		{
			if( array_key_exists( $step, $pointer ) )
			{
				$pointer = &$pointer[ $step ];
			}
			else
			{
				$path_exist = false;
				break;
			}
		}
		if( !$path_exist )
		{
			continue;
		}

		if( $op == 'replace' )
		{
			$pointer = $異文;
		}
		elseif( $op == 'insert' )
		{
			$pointer .= "[${異文}]";
		}
		else // graft
		{
			if( !array_key_exists( 樹錨名, $pointer ) )
			{
				$pointer[ 樹錨名 ] = array();
			}
			$pointer[ 樹錨名 ][] = $異文;
		}
	} // mm marker
	
	if( array_key_exists( 題注, $正文樹[ $默文檔碼 ] ) )
	{
		$題注 = $正文樹[ $默文檔碼 ][ 題注 ];
		$詩題contents .= "[${題注}]";
	}
	
	if( $是組詩 )
	{
		$首碼 = mb_substr( $默詩碼, 5 );
		
		// skip 其一
		if( mb_strpos( $正文樹[ $默文檔碼 ][ $首碼 ][ 副題 ], '其' ) === false )
		{
			$詩文contents .= $正文樹[ $默文檔碼 ][ $首碼 ][ 副題 ] . NL;
		}
	}
	
	
	$詩文 = 攤平樹文字_略過鍵( $正文樹, array( 詩題, 題注, 副題, 樹錨名 ) );
	$詩文 = str_replace( '。]。', ']。', $詩文 );
	
	if( $是組詩 )
	{
		$詩文 .= NL . NL;
	}

	if( array_key_exists( 樹錨名, $正文樹[ $默文檔碼 ] ) )
	{
		$詩文 .= NL . NL;
		
		foreach( $正文樹[ $默文檔碼 ][ 樹錨名 ] as $line )
		{
			$詩文 .= $line . NL . NL;
		}
	}

	$詩文contents .= $詩文;
}

echo $詩題contents, NL, NL, $詩文contents;

if( $生成md )
{
	file_put_contents(
		$folder . 'views' . DIRECTORY_SEPARATOR .
		$版文檔碼 . '.md', 
		'# ' . $詩題contents . NL . NL . $詩文contents );
}
?>