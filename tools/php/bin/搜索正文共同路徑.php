<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\搜索正文共同路徑.php
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

$work_id = 'LUNYU';
//$folder = get_folder( $work_id );
//$title = get_title( $work_id );

$坐標s = 搜索正文共同路徑( $work_id, '大宰知我乎' );
print_r( $坐標s );

$坐標s = 搜索正文共同路徑( $work_id, '大少' );
print_r( $坐標s );

$坐標s = 搜索正文共同路徑( $work_id, '納虐' );
print_r( $坐標s );

$坐標s = 搜索正文共同路徑( $work_id, '少納' );
print_r( $坐標s );

$坐標s = 搜索正文共同路徑( $work_id, '少氦' );
print_r( $坐標s );

$work_id = 'MENGZI';

$坐標s = 搜索正文共同路徑( $work_id, '暴天' );
print_r( $坐標s );


?>