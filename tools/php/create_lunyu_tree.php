<?php
/*
php H:\github\CanonicalTextTrees\tools\php\create_lunyu_tree.php
*/
require_once(
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );
$dir_path = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	'論語' . DIRECTORY_SEPARATOR;
$can_dir_path = $dir_path .
	'canonical_text' . DIRECTORY_SEPARATOR;
$trees_dir_path = $dir_path .
	'trees' . DIRECTORY_SEPARATOR;
$execpath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR .'生成論語樹.php';
//echo $execpath;

for( $i = 1; $i < 21; $i++ )
{
	$filename = str_pad( $i, 2, '0', STR_PAD_LEFT );
	$_GET[ 'pian' ] = $filename;
	require( $execpath );
}

$trees = [];

for( $i = 1; $i < 21; $i++ )
{
	$filename = str_pad( $i, 2, '0', STR_PAD_LEFT );
	$tree = json_decode(
		file_get_contents( $trees_dir_path . $filename .
			'.json' ), true );
	$trees[ $filename ] = $tree[ $filename ];
}

file_put_contents(
	$trees_dir_path . 'LUNYI_TREE.json',
	json_encode(
		$trees, 
		JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);


?>