<?php
/*
php H:\github\CanonicalTextTrees\tools\php\清除李善注.php
 */

require_once( 
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );
require_once( 
	dirname( __DIR__, 1 ) . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 'functions.php' );

$work_id = 'WENXUAN';
$folder = get_folder( $work_id );
$raw_dir = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR .
	$folder . DIRECTORY_SEPARATOR .
	'raw_text' . DIRECTORY_SEPARATOR;

if( !is_dir( $raw_dir ) )
{
    throw new RuntimeException(
		'文件夾不存在: ' . $raw_dir );
}
$files = scandir( $raw_dir );
sort( $files, SORT_STRING );

foreach( $files as $file )
{
	$path = $raw_dir . $file;

	if(
		is_file( $path )
		&& preg_match( '/\.txt$/i', $file )
	)
	{
		$ptn = '/〈\X+?〉/u';
		$contents = file_get_contents( $path );
		$contents = preg_replace( $ptn, '', $contents );
		file_put_contents( $path, $contents );
	}
}
?>