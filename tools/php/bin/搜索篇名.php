<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\搜索篇名.php
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
	
$work_id = 'LUNYU';	
$fragment = '學而';
$result = search_title( $work_id, $fragment );

if( $result != '' )
{
	echo $result;
}
?>