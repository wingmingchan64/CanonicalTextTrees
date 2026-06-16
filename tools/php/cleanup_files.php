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

/*
$work_id = 'SLQM';
$folder = get_ctt_folder( $work_id );
$target_folder = dirname( __DIR__, 2 ) . 
	DIRECTORY_SEPARATOR . 
	$folder . DIRECTORY_SEPARATOR .
	'canonical_text' . DIRECTORY_SEPARATOR;
	//'raw_text' . DIRECTORY_SEPARATOR;
*/
//$target_folder = "H:\github\DuFu\默認版本\文賦\\";
/*
if( !is_dir( $target_folder ) )
{
    throw new RuntimeException( '文件夾不存在: ' . $target_folder );
}
$files = scandir( $target_folder );
sort( $files, SORT_STRING );
*/
//foreach( $files as $file )
//{
	//$path = $target_folder . $file;
	$path = "H:\github\CanonicalTextTrees\corpus\dufu\杜詩詳註\canonical_text" . '\0145.txt';

	if(
		is_file( $path )
		//&& preg_match( '/\.txt$/i', $file )
	)
	{
		echo "File", NL;
		$txt = file_get_contents( $path );
		//$txt = normalize( 修復文字( $txt ) );
		$txt = 修復文字( $txt );
		//echo $txt, NL;
		file_put_contents( $path, $txt );
	}
	else
	{
		echo "not found";
	}
//}
?>