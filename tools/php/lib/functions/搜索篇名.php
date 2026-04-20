<?php
function 搜索篇名(
	string $work_id, string $title_fragment ) :
	string
{
	return search_title( $work_id, $title_fragment );
}

function search_title(
	string $work_id, string $title_fragment ) :
	string
{
	$folder = get_folder( $work_id );
	$paths_chars_path = dirname( __DIR__, 4 ) . 
		DIRECTORY_SEPARATOR .
		$folder . DIRECTORY_SEPARATOR .
		'coordinates' . DIRECTORY_SEPARATOR .
		'paths_chars.json';
	$paths_chars = json_decode(
		file_get_contents( $paths_chars_path ), 
		true );

	foreach( $paths_chars as $path => $char )
	{
		if( mb_strlen( $char ) > 1 && 
			mb_strpos( $char, $title_fragment ) !== false )
		{
			return $path . '=>' . $char;
		}
	}
	return '';
}

?>