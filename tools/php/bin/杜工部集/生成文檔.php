<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\杜工部集\生成文檔.php
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
// .txt
$start = 241;
$end = 1413;
$prev題 = '';

for( $i = $start; $i < $end; $i++ )
{
	[ $題, $碼頁 ] = explode( ' ', $lines[ $i ] );
	//echo "題:", $題, NL;
	//echo "prev題:", $prev題, NL;
	// create file
	if( $題 != $prev題 )
	{
		$prev題 = $題;
		[ $默文檔碼,$版文檔碼,$d1,$d2,$d3] = 
			explode( ',', $碼頁 );
		$默文檔碼 = preg_replace( '/-\d/','', $默文檔碼 );
		$版文檔碼 = preg_replace( '/-\d/','', $版文檔碼 );
		
		/*
		$文檔path = $folder . 
			'canonical_text' . DIRECTORY_SEPARATOR .
			$版文檔碼 . '.txt';
		if( !file_exists( $文檔path ) )
		{
			file_put_contents( $文檔path,
				$題 . NL . NL . NL .
				'===== STABLE BOUNDARY =====' . NL .
				'重現名單：' . $默文檔碼 . NL );
		}
		*/
		
		/*
		$dirpath = $folder . 
			'metadata' . DIRECTORY_SEPARATOR . 
			$版文檔碼;

		if( !is_dir( $dirpath ) )
		{
			if( mkdir( $dirpath, 0755, true ) )
			{
				// nothing
			}
			else
			{
				echo "Error: $版文檔碼", NL;
			}
		}
		*/
		$filepath = $folder . 
			'metadata' . DIRECTORY_SEPARATOR . 
			$版文檔碼 . DIRECTORY_SEPARATOR .
			'異文.txt';
		//if( !file_exists( $filepath ) )
		//{
			file_put_contents( $filepath,
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,3\"}" . NL .
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,4\"}" . NL .
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,5\"}" . NL .
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,6\"}" . NL .
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,7\"}" . NL .
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,8\"}" . NL .
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,9\"}" . NL .
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,10\"}" . NL .
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,11\"}" . NL .
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,12\"}" . NL .
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,13\"}" . NL .
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,14\"}" . NL .
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,15\"}" . NL .
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,16\"}" . NL .
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,17\"}" . NL .
			 	"{\"scope\":\"\",\"src_path\":\"WANGZHU,${版文檔碼},1,18\"}" . NL
				);
		//}
	}
	else
	{
		continue;
	}
	
}
?>