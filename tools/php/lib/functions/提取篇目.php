<?php
function get_title( string $work_id ) : string
{
	global $registry;
	return $registry[ $work_id ][ TITLE ];
}

function 提取篇目( string $work_id ) : string
{
	return get_title( $work_id );
}
?>