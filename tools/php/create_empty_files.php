<?php
/*
php H:\github\CanonicalTextTrees\tools\php\create_empty_files.php
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
	'raw_text' . DIRECTORY_SEPARATOR;

$卷 = '25.';
$篇尾 = 16;

for( $i = 1; $i <= $篇尾; $i++ )
{
	$file = $target_folder . $卷 .
		str_pad( $i, 2, '0', STR_PAD_LEFT ) . '.txt';
	file_put_contents( $file, '' );
}
?>