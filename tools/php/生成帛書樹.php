<?php
/*
php H:\github\CanonicalTextTrees\tools\php\生成帛書樹.php
*/
require_once(
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );

require_once( 'functions.php' );
$title = '老子德道經（帛書本）';

$老子path = dirname( __FILE__, 3 ) . DIRECTORY_SEPARATOR .
	'《老子》' . DIRECTORY_SEPARATOR;

$txt = file_get_contents( 
	$老子path .
	'raw_text' . DIRECTORY_SEPARATOR .
	'王弼本.txt'
);
$tree = [];
$tree = [
	'書目' => $title
];

$lines = preg_split( '/\R/u', $txt );
$line_num = 0;

foreach( $lines as $line )
{
	$line_num++;
	if( $line_num <= 37 )
	{
		$tree[ '1' ][ $line_num . '' ] = 
			line_to_sentence_tree( $line );
	}
	else
	{
		$tree[ '2' ][ $line_num . '' ] = 
			line_to_sentence_tree( $line );
	}
}

$tree[ '暫存' ] = $tree[ '1' ];
$tree[ '1' ] = $tree[ '2' ];
$tree[ '2' ] = $tree[ '暫存' ];
unset( $tree[ '暫存' ] );
//print_r( $tree );


$path = $老子path . 'tree' . DIRECTORY_SEPARATOR .
	'老子帛書本.json';
file_put_contents(
	$path,
	json_encode(
		$tree, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

//print_r( $tree );
?>