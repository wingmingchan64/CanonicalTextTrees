<?php
function is_legal_path(
	string $work_id,
	string $path,
) : bool
{
	$title = get_title( $work_id );
	
	return true;
}

function 是合法路徑( string $work_id ) : bool
{
	return is_legal_path( $work_id, $path );
}
?>