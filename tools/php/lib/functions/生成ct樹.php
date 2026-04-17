<?php
function build_ct_tree( string $txt ) : array
{
	$lines = preg_split("/\R/u", $txt);
		
	// first line is 篇名
	$篇名 = trim( $lines[ 0 ] );
	//$篇名 = $header_parts[ 0 ] ?? '';
	
	$tree = [
		篇名 => $篇名
    ];
	populate_tree( $lines, $tree );
	
	return $tree;
}

function 生成ct樹( string $txt ) : array
{
	return build_ct_tree( $txt );
}

function populate_tree( array $lines, array &$tree ) : void
{
	$counter = 0;
	
	for( $i = 1; $i < count( $lines ); $i++ )
    {
        $line_no = $i + 1;
        $line = trim( $lines[$i] );

        if( $line === '' )
        {
			$counter++;
			$tree[ ( string )$counter ] = [];
        }
		else
		{
			$tree[ ( string )$counter ][ (string)$line_no ] =
				line_to_sentence_tree( $line );
		}
    }
}

function line_to_sentence_tree( string $line ): array
{
    $result = [];

    $sentences = array_values( array_filter(
        explode( '。', trim( $line ) ),
        fn( $s ) => $s !== ''
    ) );

    foreach( $sentences as $sent_idx => $sentence )
    {
        $sent_key = ( string )( $sent_idx + 1 );
        $result[ $sent_key ] = [];

        $chars = preg_split( 
			'//u', $sentence, -1, PREG_SPLIT_NO_EMPTY );

        foreach( $chars as $char_idx => $ch )
        {
            $result[ $sent_key ][( string )( $char_idx + 1 )] = $ch;
        }
    }

    return $result;
}
?>