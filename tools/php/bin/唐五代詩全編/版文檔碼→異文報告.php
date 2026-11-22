<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\唐五代詩全編\版文檔碼→異文報告.php
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
	 
$著述碼 = 'TWDSQB10';
$版文檔碼 = '0049';
$folder = dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	get_ctt_folder( $著述碼 ) . DIRECTORY_SEPARATOR;
	
$版文檔碼_默文檔碼 =
	json_decode(
		file_get_contents( 
			$folder . '版文檔碼_默文檔碼.json' ), true );
$版文檔碼_版詩碼 =
	json_decode(
		file_get_contents( 
			$folder . '版文檔碼_版詩碼.json' ), true );
$版詩碼_默詩碼 =
	json_decode(
		file_get_contents( 
			$folder . '版詩碼_默詩碼.json' ), true );

// get default doc_ids, array!!!
$默文檔碼s = $版文檔碼_默文檔碼[ $版文檔碼 ];
$版詩碼s = $版文檔碼_版詩碼[ $版文檔碼 ];
$默詩碼s = array();
$mm樹 = 	json_decode(
		file_get_contents( 
			$folder . 'metadata' . DIRECTORY_SEPARATOR .
			'trees' . DIRECTORY_SEPARATOR .
			$版文檔碼 . '.json'
		), true )[ $著述碼 ][ $版文檔碼 ][ '異文' ];

// get default poem_ids
foreach( $版詩碼s as $版詩碼 )
{
	$默詩碼s[] = $版詩碼_默詩碼[ $版詩碼 ];
}

$正文樹文件夾 = dirname( __DIR__, 5 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	SCHEMAS_JSON_BASE_TEXT_DIR;
$是版組詩 = count( $版詩碼s ) > 1;
$mmdata = array();

foreach( $默詩碼s as $默詩碼 )
{
	$默文檔碼 = substr( $默詩碼, 0, 4 );
	$正文樹 =
		json_decode(
			file_get_contents( 
			$正文樹文件夾 . $默詩碼 . '.json' ), true );
	添加標點符號( $正文樹 );
	// 首碼
	if( $是版組詩 )
	{
		$首碼 = 提取首碼( $默詩碼 );
		$正文樹 = $正文樹[ $默文檔碼 ][ $首碼 ];
		$行s = array_keys( $正文樹[ $默文檔碼 ][ $首碼 ] );
	}
	else
	{
		$行s = array_keys( $正文樹[ $默文檔碼 ] );
	}
	
	foreach( $行s as $行 )
	{
		$mmdata[ "$行" ] = 
			攤平樹文字_略過鍵( $正文樹[ $默文檔碼 ][ "$行" ] ) . NL;
	}
	
	foreach( $mm樹 as $scope => $src_op )
	{
		$parts = explode( ',', $scope );
		
		if( $是版組詩 )
		{
			$行 = $parts[ 2 ];
		}
		else
		{
			$行 = $parts[ 1 ];
		}
		$data = "\t" . 提取路徑字( $正文樹, $parts );
		//print_r( $src_op );
		
		$src = array_keys( $src_op )[ 0 ];
		$op = $src_op[ $src ];
		
		if( $op == 'replace' )
		{
			$data .= '=>';
		}
		elseif( $op == 'insert' )
		{
			$data .= '+';
		}
		$data .= 提取ctt正文( $src ) . NL;
		$mmdata[ $行 ] = $mmdata[ $行 ] . $data;
	}
}

foreach( $mmdata as $行 => $data )
{
		echo '〚' . $行 . '〛' . $data;
}
// get poem text, with line number
// get mm data, grouped under line number
// display
?>