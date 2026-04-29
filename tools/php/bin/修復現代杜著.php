<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\修復現代杜著.php
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
	 
$work_id = 'DSSBS';
$folder = get_ctt_folder( $work_id );
$target_folder = dirname( __DIR__, 3 ) . 
	DIRECTORY_SEPARATOR . 
	$folder . DIRECTORY_SEPARATOR .
	'canonical_text' . DIRECTORY_SEPARATOR;
	//'raw_text' . DIRECTORY_SEPARATOR;
$異體字 = json_decode(
	file_get_contents(
		dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
		'schemas' . DIRECTORY_SEPARATOR .
		'json' . DIRECTORY_SEPARATOR .
		'registry' . DIRECTORY_SEPARATOR .
		'異體字.json' ), true );

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
		//echo $file, NL;
		$txt = file_get_contents( $path );
		$txt = 修復文字( $txt, false, $異體字 );
		file_put_contents( $path, $txt );
	}
}

?>