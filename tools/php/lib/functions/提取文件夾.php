<?php
function get_folder( string $work_id ) : string
{
	global $ctt_registry;
	return $registry[ $work_id ][ FOLDER ];
}

function 提取文件夾( string $work_id ) : string
{
	return get_folder( $work_id );
}
?>