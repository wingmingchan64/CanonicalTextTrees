<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\views\版本文檔碼→文賦.php 1099
*/
use Dufu\Exceptions\DocumentIDNotFoundException;

require_once(
	dirname( __DIR__, 5 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );

$生成md  = true;
//$卷次 = '六';

$著述碼 = 'WANGZHU';
$folder = dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	get_ctt_folder( $著述碼 ) . DIRECTORY_SEPARATOR;

/*
$卷碼陣列 = json_decode(
	file_get_contents( $folder . '卷目_文檔碼.json' ),
	true );
[ $start, $end ] = $卷碼陣列[ $卷次 ];
$multiple_contents = "# 卷${卷次}" . NL . NL;
*/
// a single 版文檔碼
/**/
check_argv( $argv, 2, "必須提供版本文檔碼" );
$版文檔碼 = fix_doc_id( trim( $argv[ 1 ] ) );
/**/

// loop 版文檔碼
/*
for( $i = $start; $i <= $end; $i++ )
{
	$版文檔碼 = fix_doc_id( "$i" );
*/	
// common code
/*
$版詩碼s = $map[ $版文檔碼 ];
$是組詩 = count( $版詩碼s ) > 1;
$題注set = false;
$版詩碼_默詩碼 = json_decode(
	file_get_contents( $folder . '版詩碼_默詩碼.json' ), true );
*/
// 版本篇名
$篇名path = $著述碼 . ',' . $版文檔碼 . ',' . '篇名';
$題注set = false;

// 文賦異文
$文賦題 = str_replace( '【', '[',
		str_replace( '】', ']', 提取ctt正文( $篇名path ) ) );
$文賦contents = $版文檔碼 . ' ' . $文賦題 . NL . NL;
$mm_tree_path = $folder . 
	'metadata' . DIRECTORY_SEPARATOR . 
	'trees' . DIRECTORY_SEPARATOR . 
	$版文檔碼 . '.json';

if( file_exists( $mm_tree_path ) )
{
	$mm_tree = 提取後設資料樹( $著述碼, $版文檔碼 );
	$paths = array();
	記錄後設資料樹路徑( $mm_tree );
}
else
{
	$mm_tree = null;
}

$默文檔碼 = 文賦默認文檔碼_洙文檔碼[ $版文檔碼 ];
$文賦文檔路徑 = $filepath = 
		dirname( __DIR__, 5 ) . DIRECTORY_SEPARATOR .
		杜甫分析文件夾 .
		SCHEMAS_JSON_BASE_TEXT_DIR . "${默文檔碼}.json";
$正文樹 = json_decode(
	file_get_contents( $filepath ), true )
		[ $默文檔碼 ];
添加標點符號( $正文樹 );

if( is_null( $mm_tree ) )
{} // do nothing
else
{
	foreach( $paths as $path )
	{
		$parts = explode( '_', $path );
		$默路徑 = explode( ',', $parts[ 3 ] );
		$異文 = 提取ctt正文( $parts[ 4 ] );
		$op = $parts[ 5 ];
		$pointer = &$正文樹;
		$path_exist = true;
		
		// delete text
		if( $異文 == '空語鏈' )
		{
			$異文 = '';
		}
		//print_r( $默路徑 );


		foreach( $默路徑 as $step )
		{
			if( $step == 題注 )
			{
				$pointer[ 篇名 ] = $pointer[ 篇名 ] .
				'[' . $異文 . ']';
				$題注set = true;
				continue;
			}
			
			if( is_array( $pointer ) && 
				array_key_exists( $step, $pointer ) )
			{
				$pointer = &$pointer[ $step ];
			}
		}

		
		//print_r( $正文樹 );

		if( $op == 'replace' )
		{
			//echo "Replacing", NL;
			$pointer = $異文;
		}
		elseif(  $op == 'insert' )
		{
			//echo "Inserting", NL;
			if( $題注set )
			{
				continue;
			}
			$pointer .= "[${異文}]";
		}
		elseif( $op == 'graft' )
		{
			if( !array_key_exists( 樹錨名, $pointer ) )
			{
				$pointer[ 樹錨名 ] = array();
			}
			$pointer[ 樹錨名 ][] = $異文;
		}
	} // mm marker
}

//print_r( $正文樹 );

foreach( array_keys( $正文樹 ) as $key )
{
	if( $key == 篇名 )
	{
		$文賦contents = $版文檔碼 . ' ' . $正文樹[ 篇名 ] . NL . NL;
		//continue;
	}
	else
	{
		//echo $key, NL;
		//echo 提取文賦段落( $正文樹[ $key ] ), NL;
		
		$文賦contents .=
			提取文賦段落( $正文樹[ $key ] ) . NL . NL;
	}
}


// single
if( !$生成md )
{
	echo $文賦contents;
}
else
{
	// multiple
	$文賦contents =
		'## ' . $文賦contents . NL . NL;
}

/*
} // end for loop
*/

if( $生成md )
{
	/*
	// a single 版文檔碼
	file_put_contents(
		$folder . 'views' . DIRECTORY_SEPARATOR .
		$版文檔碼 . '.md', 
		'# ' . $詩題contents . NL . NL . $詩文contents );
	*/
	/**/
	// multiple poems in a single file
	file_put_contents(
		$folder . 'views' . DIRECTORY_SEPARATOR .
		//'卷' . $卷次 . 
		"${版文檔碼}.md",
		str_replace( '[', '<sub>[',
			str_replace( ']', ']</sub>',
				str_replace( 
					NL.NL.NL, NL, 
					$文賦contents ) ) ) 
		);
	/**/
}

?>