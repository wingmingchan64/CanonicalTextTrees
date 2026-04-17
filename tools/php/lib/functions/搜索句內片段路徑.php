<?php
function 搜索句內片段路徑(
	string $work_id, string $片段 ) : array
{ 
	global $registry;
	$folder = get_folder( $work_id );
	$title = get_title( $work_id );

	$segments_paths = json_decode(
		file_get_contents( 
		dirname( __FILE__, 4 ) . 	
		DIRECTORY_SEPARATOR .
		get_title( $work_id ) .
		DIRECTORY_SEPARATOR .
		'coordinates' . DIRECTORY_SEPARATOR . 
		'segments_paths.json' ), true );
	$segments = array_keys( $segments_paths );
	$result = array();
	
	foreach( $segments as $segment )
	{
		if( mb_strpos( $segment, $片段 ) !== false )
		{
			$result = $segments_paths[ $segment ];
		}
	}
	return $result;
}

function search_in_segment_for_path(
	string $work_id, string $片段 ) : array
{ 
	return 搜索句內片段路徑( $work_id, $片段 );
}
?>