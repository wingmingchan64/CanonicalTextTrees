<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\convert_dufu_poems.php
 */
require_once( 
	dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );

require_once( 
	dirname( __DIR__, 1 ) . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 'functions.php' );
 
$work_id = 'QTS';
$folder = get_folder( $work_id );
$title = get_title( $work_id );
$display_title = get_display_title( $work_id );

$dufu_QTS_dir = dirname( __DIR__, 4 ) . 
	DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'bin' . DIRECTORY_SEPARATOR .
	'catalog' . DIRECTORY_SEPARATOR;
$ctt_qts_dir = dirname( __DIR__, 3 ) .
	DIRECTORY_SEPARATOR .
	$folder . DIRECTORY_SEPARATOR .
	'canonical_text' . DIRECTORY_SEPARATOR;
//echo $ctt_qts_dir, NL;

$catalog = file_get_contents( 
	$dufu_QTS_dir . '全目錄.txt' );
$list = preg_split( '/\R/u', $catalog );
$默詩_dir = dirname( __DIR__, 4 ) . 
	DIRECTORY_SEPARATOR .
	'DuFu' . DIRECTORY_SEPARATOR .
	'默認版本' . DIRECTORY_SEPARATOR .
	'詩' . DIRECTORY_SEPARATOR;

// 217, line 54,95,173,209,262,315,362，406,488,609,712,837,933,1055,1194,1291，1345，1403
for( $i = 1403; $i < 1454; $i++ )
{
	$line = $list[ $i ];
	$parts = explode( ' ', $line );
	$默文檔碼 = $parts[ 2 ];
	
	if( strlen( $默文檔碼 ) > 4 )
	{
		$默文檔碼 = substr( $默文檔碼, 0, 4 );
	}
	$parts = explode( ',', $parts[ 3 ] );
	$全文檔碼 = $parts[ 0 ];
	//echo $全文檔碼, NL;
	
	if( strlen( $全文檔碼 ) > 4 )
	{
		$parts = explode( '-', $全文檔碼 );
		//$全文檔碼 = substr( $parts[ 0 ], 1, 3 );
		$全文檔碼 = $parts[ 0 ];
		$全文檔碼 = intval( $全文檔碼 ) - 1091;
		$全文檔碼 = str_pad( $全文檔碼, 3, '0', STR_PAD_LEFT );
		
		$首碼 = str_pad( $parts[ 1 ], 2, '0', STR_PAD_LEFT );
		$全文檔碼 = $全文檔碼 . '-' . $首碼;
	}
	else
	{
		$全文檔碼 = $parts[ 0 ];
		$全文檔碼 = intval( $全文檔碼 ) - 1091;
		$全文檔碼 = str_pad( $全文檔碼, 3, '0', STR_PAD_LEFT );
	}
	
	$file = '234.' . $全文檔碼 . '.txt';
	
	$contents = file_get_contents(
		$默詩_dir . $默文檔碼 . '.txt' );
	$contents = 
		trim( str_replace( $默文檔碼, '杜甫', $contents ) );
	
	//echo $ctt_qts_dir . $file, NL;
	file_put_contents( $ctt_qts_dir . $file, $contents );
	//echo $contents, NL;
}

?>
