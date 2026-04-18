<?php
function is_scoped_path(
	string $path, 
	array &$paths=null, 
	bool $punc=false ) : bool
{
	$paths = array(); // empty everything
	$parts = explode( ',', $path );
	$num_of_parts = count( $parts );
	$work_id = $parts[ 0 ];
	$temp = [];
	
	// char, segment, line, chapter
	// not work_id, nor doc_id
	if( $num_of_parts < 3 )
	{
		return false;
	}
	
	// only the last part can have -
	for( $i = 0; $i < $num_of_parts - 1; $i++ )
	{
		if( strpos( $parts[ $i ], '-' ) !== false )
		{
			return false;
		}
	}
	
	$last_part = $parts[ $num_of_parts - 1 ];
	
	// need path to parent
	$parts_no_last = array_splice( $parts, 0, $num_of_parts - 1 );
	$parent = implode( ',', $parts_no_last );
	
	// last part must have -
	if( strpos( $last_part, '-' ) === false )
	{
		return false;
	}
	
	$range = explode( '-', $last_part );
	
	if( count( $range ) != 2 )
	{
		return false;
	}
	
	$min = intval( $range[ 0 ] );
	$max = intval( $range[ 1 ] );
	
	if( $min >= $max )
	{
		return false;
	}

	foreach( range( $min, $max ) as $child )
	{
		$temp[] = $parent . ',' . $child;
	}
	global $registry;
	
	if( !in_array( $work_id, array_keys( $registry ) ) )
	{
		return false;
	}

	foreach( $temp as $path )
	{
		if( 是合法路徑( $work_id, $path ) == false )
		{
			return false;
		}
	}
	
	//$folder = get_folder( $work_id );
	
	if( !is_null( $paths ) )
	{
		foreach( $temp as $path )
		{
			$paths[ $path ] = 
				retrieve_text_from_canonical_tree( $path, $punc );
		}
	}
	return true;
}

function 是範圍路徑( 
	string $path, 
	array &$paths=null, 
	bool $punc=false ) : bool
{
	return is_scoped_path( $path, $paths, $punc );
}
?>