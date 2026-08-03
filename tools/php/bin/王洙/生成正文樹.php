<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\王洙\生成正文樹.php
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
$mapping_file = "默詩碼_版詩碼.json";
$map = json_decode(
	file_get_contents( $folder . $mapping_file ), true );

foreach( $map as $默詩碼 => $版詩碼 )
{
	if( strlen( $默詩碼 ) != 4 )
	{
		$默文檔碼 = substr( $默詩碼, 0, 4 );
		$版文檔碼 = substr( $版詩碼, 0, 4 );
	}
	else
	{
		$默文檔碼 = $默詩碼;
		$版文檔碼 = $版詩碼;
	}
	
	$m_file = $folder . 'metadata' . DIRECTORY_SEPARATOR .
		'trees' . DIRECTORY_SEPARATOR .
		$版文檔碼 . '.json';
	$基準正文樹 = 提取基準正文樹( $默文檔碼 );
	
	if( file_exists( $m_file ) )
	{
		$mm = json_decode(
			file_get_contents( $m_file ), true 
		);
		//print_r( $mm );
		
		foreach( $mm[ $著述碼 ][ $版文檔碼 ][ '異文' ]
			as $默path => $版path_函 )
		{
			//print_r( $默path );
			
			foreach( $版path_函 as $版path => $函式 )
			{
				if( $函式 == 'replace' )
				{
					$文字 = 提取ctt正文( $版path );
					
					if( mb_strpos( $默path, '題注' ) !== false )
					{
						$文字 = "[${文字}]";
					}
					
					替換路徑字(
						$基準正文樹,
						explode( ',', $默path ),
						$文字
					);
				}
				else
				{
					$文字 = '['. 提取ctt正文( $版path ) . ']';
					插入路徑字(
						$基準正文樹,
						explode( ',', $默path ),
						$文字
					);
				}
			}
		}
	}
		
	//print_r( $基準正文樹 );
		
	$tree_path = $folder .
		'views' . DIRECTORY_SEPARATOR .
		$版文檔碼 . '.json';

	file_put_contents(
		$tree_path,
		json_encode(
			$基準正文樹, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) );
}
	//print_r( $基準正文樹 );
?>