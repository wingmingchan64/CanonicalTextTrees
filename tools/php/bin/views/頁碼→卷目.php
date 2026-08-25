<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\views\頁碼→卷目.php
*/
require_once(
	dirname( __DIR__, 5 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );
$著述碼 = 'WANGZHU';
$page_num = 235;
$foler = 提取ctt文件夾( $著述碼 );
$卷目_頁碼file =
	dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	$foler . DIRECTORY_SEPARATOR .
	'卷目_頁碼.json';
$contents = file_get_contents( $卷目_頁碼file );
$卷目_頁碼 = json_decode( $contents, true );
$頁碼_卷目 = array_flip( $卷目_頁碼 );
$頁碼 = array_keys( $頁碼_卷目 );

if( $page_num < $頁碼[ 0 ] || 
	$page_num > $頁碼[ count( $頁碼 ) - 1 ] )
{
	echo "Unacceptable page number", NL;
	exit;
}

for( $i = 0; $i < count( $頁碼_卷目 ); $i++ )
{
	if( $頁碼[ $i ] <= $page_num && 
		$page_num <= $頁碼[ $i + 1 ] )
	{
		echo $頁碼_卷目[ $頁碼[ $i ] ], NL;
		break;
	}
}
?>