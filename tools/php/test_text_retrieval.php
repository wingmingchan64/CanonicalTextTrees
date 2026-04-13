<?php
/*
php H:\github\CanonicalTextTrees\tools\php\test_text_retrieval.php
 */

require_once( 
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );

require_once( 
	__DIR__ . DIRECTORY_SEPARATOR .
	 'functions.php' );

retrieve_text_from_canonical_tree( 'LUNYU', 
	explode( ',', '03,4,9,1' ) );
?>
