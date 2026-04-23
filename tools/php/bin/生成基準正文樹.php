<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\生成基準正文樹.php
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
	 
$work_id = 'BDS';
$ascii = true;

$folder = get_folder( $work_id );
$title = get_title( $work_id );
$display_title = get_display_title( $work_id );

$book_ct_dir = dirname( __DIR__, 3 ) . 
	DIRECTORY_SEPARATOR .
	$folder . DIRECTORY_SEPARATOR .
	'canonical_text' . DIRECTORY_SEPARATOR;

if( !is_dir( $book_ct_dir ) )
{
    throw new RuntimeException( '正文文件夾不存在: ' . $book_ct_dir );
}
$files = scandir( $book_ct_dir );
sort( $files, SORT_STRING );

foreach( $files as $file )
{
	$path = $book_ct_dir . $file;

	if(
		is_file( $path )
		&& preg_match( '/\.txt$/i', $file )
	)
	{
		$篇 = str_replace( '.txt', '', $file );
		$txt = file_get_contents( $path );
		$tree = build_ct_tree( $txt, $ascii );

		$tree_path = dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
			$folder . DIRECTORY_SEPARATOR . 
			'trees' . DIRECTORY_SEPARATOR . $篇 . '.json';
		file_put_contents(
			$tree_path,
			json_encode(
				array( $篇 => $tree ), 
				JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
		);
	}
}

//print_r( $to_restore );
?>