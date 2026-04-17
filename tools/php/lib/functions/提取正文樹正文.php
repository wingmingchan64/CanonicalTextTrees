<?php
function retrieve_text_from_canonical_tree(
	string $path, bool $add_punctuation = false ) : string
{
	$parts = explode( ',', $path );
	$work_id = $parts[ 0 ];
	
	if( !is_legal_path( $parts[ 0 ], $path ) )
	{
		throw new CTT\Exceptions\IllegalCoordinateException( $path . " not a legal path." );
	}
	global $registry;
	
	$tree_path = dirname( __FILE__, 4 ) . 	
		DIRECTORY_SEPARATOR .
		get_title( $work_id ) .
		DIRECTORY_SEPARATOR .
		'trees' . DIRECTORY_SEPARATOR . 
		$parts[ 1 ] . '.json';
	
	$tree = json_decode(
		file_get_contents( $tree_path ), true );
		
	if( $add_punctuation )
	{
		add_punctuation( $tree );
	}
	//print_r( $tree );
	$pointer = $tree;
	
	for( $i = 1; $i < count( $parts ); $i++ )
	{
		$pointer = $pointer[ $parts[ $i ] ];
	}

	return  flatten_tree_to_text_skip_keys( [ $pointer ] );;
}

function 提取正文樹正文(
	string $path, bool $add_punctuation = false ) : string
{
	return retrieve_text_from_canonical_tree(
		$path, $add_punctuation );
}
?>