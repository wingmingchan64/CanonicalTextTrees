<?php
/*
php H:\github\CanonicalTextTrees\tools\php\生成text_trees.php
 */
require_once( 
	__DIR__ . DIRECTORY_SEPARATOR .
	 'functions.php' );
$txt_dir = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	'《詩經》' . DIRECTORY_SEPARATOR .
	'canonical_text' . DIRECTORY_SEPARATOR;
$tree_dir = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	'《詩經》' . DIRECTORY_SEPARATOR .
	'trees' . DIRECTORY_SEPARATOR;

if( !is_dir( $txt_dir ) )
{
    throw new RuntimeException( 'raw_text 目錄不存在: ' . $excep_dir );
}
$files = scandir( $txt_dir );
sort( $files, SORT_STRING );

foreach( $files as $file )
{
	$text_file_path = $txt_dir . $file;

	if(
		is_file( $text_file_path )
		&& preg_match( '/\.txt$/i', $file )
	)
	{
		$tree_file_path = $tree_dir . 
			str_replace( '.txt', '.json', $file );

		$tree = build_text_tree( 
			file_get_contents( $text_file_path ), '篇目'
		);
		file_put_contents(
			$tree_file_path,
			json_encode(
				$tree, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
		);
	}
}

/*
$文檔 = '01.01';
$text_file_path = $txt_dir . $文檔 . '.txt';

$tree = build_text_tree( 
	file_get_contents( $text_file_path ), '篇目'
);

file_put_contents(
	$tree_file_path,
	json_encode(
		$tree, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);
*/
?>
