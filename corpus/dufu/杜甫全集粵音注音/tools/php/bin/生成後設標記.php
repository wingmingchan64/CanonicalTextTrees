<?php
/*
php H:\github\CanonicalTextTrees\corpus\dufu\杜甫全集粵音注音\tools\php\bin\生成後設標記.php
*/
require_once(
	dirname( __DIR__, 7 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	'函式.php' );

$文檔碼 = '0943';
$start = 3;
$end = 72;

for( $i = $start; $i <= $end; $i++ )
{
	$行 = $i-2;
$marker = <<<EOD
{"scope":"${文檔碼},${i}","src_path":"OWEN,05.27,${行}"}
EOD;
	echo $marker, NL;
}
?>