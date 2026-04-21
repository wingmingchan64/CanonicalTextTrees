<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\搜索紅樓夢正文共同路徑.php
*/
require_once(
	dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );
require_once( 
	dirname( __DIR__, 1 ) . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 'functions.php' );

$work_id = 'HLM';

$坐標s = 搜索正文共同路徑( $work_id, '黛寶玉' );
print_r( $坐標s );
$坐標s = 搜索正文共同路徑( $work_id, '釵寶玉' );
print_r( $坐標s );
$坐標s = 搜索正文共同路徑( $work_id, '寶玉湘雲' );
print_r( $坐標s );
//$坐標s = 搜索正文共同路徑( $work_id, '寒塘冷月' );
//print_r( $坐標s );

?>