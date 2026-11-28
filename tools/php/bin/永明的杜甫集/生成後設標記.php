<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\永明的杜甫集\生成後設標記.php
*/

require_once(
	dirname( __DIR__, 5 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );
$默文檔碼_詩文 = 提取數據結構( 默認詩文檔碼_詩文 );
$默文檔碼 = '0943';
$詩文s = explode( '。', $默文檔碼_詩文[ $默文檔碼 ] );
//print_r( $詩文s );

foreach( $詩文s as $詩文 )
{
	$template = "{\"scope\":\"${詩文}\",\"src_path\":\"\"}";

	if( $詩文 != '' )
	{
		echo $template, NL;
	}
}
?>