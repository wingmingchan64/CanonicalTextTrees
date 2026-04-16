<?php
function get_display_title( string $work_id ) : string
{
	global $registry;
	return $registry[ $work_id ][ DISPLAY_TITLE ];
}

function 提取顯示篇目( string $work_id ) : string
{
	return get_display_title( $work_id );
}
?>