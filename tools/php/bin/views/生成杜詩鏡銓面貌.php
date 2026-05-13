<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\views\生成杜詩鏡銓面貌.php
*/
use CTT\Exceptions\IllegalWorkIDException;
use Dufu\Exceptions\JsonFileNotFoundException;
use Dufu\Exceptions\InvalidAnchorValueException;

require_once(
	dirname( __DIR__, 5 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );
	
$默文碼 = '0668';
$著述碼 = 'JINGQUAN';
$版文檔碼 = '0097';

$m_tree = 提取後設資料樹( $著述碼, $版文檔碼 );
$paths = array();
$m_paths = 記錄後設資料樹路徑( $m_tree );
$folder = 提取ctt文件夾( $著述碼 );
$樹 = 挂樹飾( $默文碼, "${著述碼},${版文檔碼}", $paths );

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
		$樹, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

$template = file_get_contents(
	dirname( __FILE__, 5 ) . DIRECTORY_SEPARATOR .
	$folder . DIRECTORY_SEPARATOR .
	'模板.html' );
$詩題 = $樹[ $默文碼 ][ '詩題' ][ '題' ];
$題解 = $樹[ $默文碼 ][ '詩題' ][ 'a' ];
$眉批 = $樹[ $默文碼 ][ 'a' ];

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

$樹[ $默文碼 ][ '詩題' ] = '';
$樹[ $默文碼 ][ 'a' ] = '';
$評論 = $樹[ 'a' ];
$樹[ 'a' ] = '';
$詩文 = 攤平樹文字_略過鍵( $樹 );
$詩文 = preg_replace( 夾注regex, '', $詩文 );
$評論 = '<p class="評論">' . $評論 . '</p>';
$評論 = str_replace( '◯', '</p><p class="評論">', $評論 );
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
?>