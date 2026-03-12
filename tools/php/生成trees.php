<?php
/*
php H:\github\QuanTangShi\tools\php\生成trees.php
 */
 /*
require_once( 
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );
*/
require_once( 
	__DIR__ . DIRECTORY_SEPARATOR .
	 'functions.php' );
$txt_dir = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR . 'canonical_txt' . DIRECTORY_SEPARATOR;
$tree_dir = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR . 'trees' . DIRECTORY_SEPARATOR;
$group_map = json_decode( file_get_contents(
	__DIR__ . DIRECTORY_SEPARATOR . '組詩_副題.json' ), true );

build_tree_corpus( $txt_dir, $tree_dir, $group_map );

?>
