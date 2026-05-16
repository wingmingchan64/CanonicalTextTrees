<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\views\生成杜詩鏡銓面貌.php
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
	
$默文檔碼 = '0003';
$著述碼   = 'JINGQUAN';
$版文檔碼 = '0002';

$m_tree = 提取後設資料樹( $著述碼, $版文檔碼 );
$paths = array();
$m_paths = 記錄後設資料樹路徑( $m_tree );
$folder = 提取ctt文件夾( $著述碼 );
$樹 = 挂樹飾( $默文檔碼, "${著述碼},${版文檔碼}", $paths );
/*
$顔色表 = json_decode(
	file_get_contents( dirname( __FILE__, 5 ) . 	
	DIRECTORY_SEPARATOR .
	$folder . DIRECTORY_SEPARATOR .
	METADATA_DIR . '旁圈.json' ), true )[ $默文檔碼 ];
//print_r( $顔色表 );

foreach( $顔色表 as $路徑 )
{
	加句顔色( $樹, $路徑 );
}
*/
//print_r( $樹 );

$json_path = dirname( __FILE__, 5 ) . DIRECTORY_SEPARATOR .
	$folder . DIRECTORY_SEPARATOR .
	'views' . DIRECTORY_SEPARATOR .
	"${版文檔碼}.json";

file_put_contents(
	$json_path,
	json_encode(
		$樹, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

//echo 攤平樹文字_略過鍵( $樹, [ '詩題' ] ), NL;
生成HTML面貌( $樹 );
//print_r( $樹 );
//exit;


$json_path = dirname( __FILE__, 5 ) . DIRECTORY_SEPARATOR .
	$folder . DIRECTORY_SEPARATOR .
	'views' . DIRECTORY_SEPARATOR .
	"${版文檔碼}html.json";

file_put_contents(
	$json_path,
	json_encode(
		$樹, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT )
);

$template = file_get_contents(
	dirname( __FILE__, 5 ) . DIRECTORY_SEPARATOR .
	$folder . DIRECTORY_SEPARATOR .
	'模板.html' );
$詩題 = $樹[ $默文檔碼 ][ 詩題 ][ '題' ];
$題解 = $樹[ $默文檔碼 ][ 詩題 ][ 樹錨名 ][ '楊' ];
$眉批 = $樹[ $默文檔碼 ][ 樹錨名 ][ '楊' ];

if( $眉批 != '' )
{
	if( mb_strpos( $眉批, '〖' ) !== false )
	{
		$眉批s = explode( '〖', $眉批 );
	

		foreach( $眉批s as $part )
		{
			if( mb_strpos( $part, '〗' ) === false )
			{
				$眉批 = $part;
			}
			else
			{
				preg_match_all( '/(\d+?)〗/u', $part, $matches );
				//print_r( $matches[ 1 ][ 0 ] );
				$part = preg_replace( '/\d+?〗/u', 
					str_repeat( "<br />", 
						intval( $matches[ 1 ][ 0 ] ) ),
					$part );
				$眉批 .= $part;
			}
		}
	}
}

$樹[ $默文檔碼 ][ '詩題' ] = '';
$樹[ $默文檔碼 ][ 樹錨名 ][ '楊' ] = '';
$評論 = '';
if( is_array( $樹[ 樹錨名 ] ) )
{
	$評論 = $樹[ 樹錨名 ][ '楊' ];
	$樹[ 樹錨名 ][ '楊' ] = '';
	$評論 = '<p class="評論">' . $評論 . '</p>';
	$評論 = str_replace( '◯', '</p><p class="評論">', $評論 );
}

$詩文 = 攤平樹文字_略過鍵( $樹, array( 題注, 序言 ) );

$template = str_replace( '〘詩題〙', $詩題, $template );
$template = str_replace( '〘題解〙', $題解, $template );
$template = str_replace( '〘眉批〙', $眉批, $template );
$template = str_replace( '〘詩文〙', $詩文, $template );
$template = str_replace( '〘評論〙', $評論, $template );

file_put_contents( 
	dirname( __dir__, 4 ) . DIRECTORY_SEPARATOR .
	$folder . DIRECTORY_SEPARATOR .
	'views' . DIRECTORY_SEPARATOR .
	"${版文檔碼}.html", $template );

// 句$path
function 加句顔色( array &$tree, string $path )
{
	$路徑 = explode( 逗號, $path );
	$pointer = &$tree;
	
	foreach( $路徑 as $step )
	{
		$pointer = &$pointer[ $step ];
	}
	
	$pointer[ '1' ] = '<span class="旁圈">' . $pointer[ '1' ];
	$pointer[ (string)提取路徑句字數( $path ) ] =
		$pointer[ (string)提取路徑句字數( $path ) ] . '</span>';
	//print_r( $tree );
}

?>