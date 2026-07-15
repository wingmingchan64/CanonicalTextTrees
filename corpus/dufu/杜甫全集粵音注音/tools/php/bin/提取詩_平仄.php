<?php
/*
php H:\github\CanonicalTextTrees\corpus\dufu\杜甫全集粵音注音\tools\php\bin\提取詩_平仄.php
*/
require_once(
	dirname( __DIR__, 7 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	'函式.php' );
$平仄_dir =
	dirname( __DIR__, 7 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	SCHEMAS_JSON_平仄_DIR;
$文檔碼 = '0943';

$樹 = json_decode(
	file_get_contents( $平仄_dir . $文檔碼 . '.json' ), true );

foreach( $樹[ $文檔碼 ] as $k => $v )
{
	if( intval( $k ) )
	{
		foreach( $樹[ $文檔碼 ][ $k ] as $句碼 => $字 )
		{
			echo 攤平樹文字_略過鍵( $樹[ $文檔碼 ][ $k ][ $句碼 ] ), '。';
		}
		echo NL;
	}
}

?>