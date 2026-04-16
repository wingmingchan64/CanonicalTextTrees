<?php
function get_num_of_chapters( string $work_id ) : string
{
	global $registry;
	return $registry[ $work_id ][ NUM_OF_CHAPTERS ];
}

function 提取篇數目( string $work_id ) : string
{
	return get_num_of_chapters( $work_id );
}
?>