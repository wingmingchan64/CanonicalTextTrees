<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\生成原始文本.php
 */
require_once( 
	dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );
require_once( 
	dirname( __DIR__, 1 ) . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 'functions.php' );
	 
$work_id = 'WENXUAN';
$folder = get_folder( $work_id );
$title = get_title( $work_id );
$display_title = get_display_title( $work_id );

$raw_text_path = dirname( __DIR__, 3 ) .
	DIRECTORY_SEPARATOR .
	$folder . DIRECTORY_SEPARATOR .
	'raw_text' . DIRECTORY_SEPARATOR ;

if( !is_dir( $raw_text_path ) )
{
    throw new RuntimeException( '正文文件夾不存在: ' . $raw_text_path );
}
$files = scandir( $raw_text_path );
sort( $files, SORT_STRING );

foreach( $files as $file )
{
	$path = $raw_text_path . $file;

	if(
		is_file( $path )
		&& preg_match( '/\.txt$/i', $file )
	)
	{
		$contents = file_get_contents( $path );
		$contents = normalize( $contents, true, true );

		foreach( $異體字 as $異 => $正 )
		{
			$contents = str_replace( $異, $正, $contents );
		}

		file_put_contents( $path, $contents );
	}
}
?>
