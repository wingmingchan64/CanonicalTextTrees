<?php
/*
php H:\github\CanonicalTextTrees\tools\php\生成text_trees.php
 */
require_once( 
	__DIR__ . DIRECTORY_SEPARATOR .
	 'functions.php' );
$txt_dir = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	'《文選》' . DIRECTORY_SEPARATOR .
	'canonical_text' . DIRECTORY_SEPARATOR;
$tree_dir = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	'《文選》' . DIRECTORY_SEPARATOR .
	'trees' . DIRECTORY_SEPARATOR;
$文檔 = '32.01';
$text_file_path = $txt_dir . $文檔 . '.txt';
$tree_file_path = $tree_dir . $文檔 . '.json';

$tree = build_text_tree( 
	file_get_contents( $text_file_path ), '篇目'
);
//print_r( $tree );

file_put_contents(
	$tree_file_path,
	json_encode(
		$tree, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

?>
