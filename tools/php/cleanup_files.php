<?php
/*
php H:\github\CanonicalTextTrees\tools\php\cleanup_files.php
*/
require_once(
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );
require_once( 
	dirname( __DIR__, 1 ) . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 'functions.php' );
	 
$work_id = 'WENXUAN';
$folder = get_folder( $work_id );
$target_folder = dirname( __DIR__, 2 ) . 
	DIRECTORY_SEPARATOR . 
	$folder . DIRECTORY_SEPARATOR .
	'canonical_text' . DIRECTORY_SEPARATOR;

if( !is_dir( $target_folder ) )
{
    throw new RuntimeException( '文件夾不存在: ' . $target_folder );
}
$files = scandir( $target_folder );
sort( $files, SORT_STRING );

foreach( $files as $file )
{
	$path = $target_folder . $file;

	if(
		is_file( $path )
		&& preg_match( '/\.txt$/i', $file )
	)
	{
		$txt = file_get_contents( $path );
		$txt = normalize( 修復文字( $txt ) );
		file_put_contents( $path, $txt );
	}
}
?>