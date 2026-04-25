<?php
$to_skip = array(
	'Mr.' => 'Mr',
	'Mrs.' => 'Mrs'
);
$to_restore = array_flip( $to_skip );

function build_ct_tree( string $txt, bool $ascii=false, bool $modern=false, bool $line_intact=false ) : array
{
	$lines = preg_split("/\R/u", $txt);
		
	// first line is 篇名
	$篇名 = trim( $lines[ 0 ] );
	//$篇名 = $header_parts[ 0 ] ?? '';
	
	$tree = [
		篇名 => $篇名
    ];
	populate_tree( $lines, $tree, $ascii, $modern, $line_intact );
	
	return $tree;
}

function 生成ct樹( string $txt ) : array
{
	return build_ct_tree( $txt );
}

function populate_tree( 
	array $lines, array &$tree, 
	bool $ascii, bool $modern, bool $line_intact ) : void
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
			if( $line_intact )
			{
				$tree[ ( string )$counter ][ (string)$line_no ] = $line;
			}
			else
			{
				$tree[ ( string )$counter ][ (string)$line_no ] =
					line_to_sentence_tree(
						$line, $ascii, $modern, $line_intact );
			}
		}
    }
}

function line_to_sentence_tree( 
	string $line, bool $ascii, bool $modern ): array
{
    $result = [];

	if( !$ascii )
	{
		$sentences = array_values( array_filter(
			explode( '。', trim( $line ) ),
			fn( $s ) => $s !== ''
		) );

		foreach( $sentences as $sent_idx => $sentence )
		{
			if( $modern )
			{
				$sentence .= '。';
			}
			
			$sent_key = ( string )( $sent_idx + 1 );
			$result[ $sent_key ] = [];

			$chars = preg_split( 
				'//u', $sentence, -1, PREG_SPLIT_NO_EMPTY );

			foreach( $chars as $char_idx => $ch )
			{
				$result[ $sent_key ][( string )( $char_idx + 1 )] = $ch;
			}
		}
	}
	else
	{
		global $to_skip;
		global $to_restore;
		
		//$ptn = '/\s(\w+-\w+-\w+)|(\w+-\w+)[\W\s]/';
		$ptn = '/\s((\w+-)+\w+)[\W\s]/';
		$matches = array();
		$r = preg_match_all( $ptn, $line, $matches );
		
		if( $r )
		{
			$k = trim( $matches[ 0 ][ 0 ] );
			$v = trim( str_replace( '-', '', $k ) );
			$to_skip[ $k ] = $v;
			$to_restore[ $v ] = $k;
		}
		
		foreach( $to_skip as $k => $v )
		{
			$line = str_replace( $k, $v, $line );
		}
		
		$iterator = IntlBreakIterator::createSentenceInstance( 'en_US' );
		$iterator->setText( $line );

		$sentences = [];
		$start = 0;
		
		foreach( $iterator as $boundary )
		{
			$substr = trim( substr(
				$line, $start, $boundary - $start ) );
				
			if( $substr != "" )
			{
				$sentences[] = $substr;
			}
			$start = $boundary;
		}
		
		foreach( $sentences as $sent_idx => $sentence )
		{
			$sent_key = ( string )( $sent_idx + 1 );
			$result[ $sent_key ] = [];
			$words = preg_split(
				'/(\W)/u', $sentence, -1,  PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
			$temp = [];

			foreach( $words as $word )
			{
				$word = trim( $word );
				
				if( array_key_exists( $word, $to_restore ) )
				{
					$word = $to_restore[ $word ];
				}
				if( $word != "" )
					$temp[] = $word;
			}
			
			foreach( $temp as $char_idx => $ch )
			{
				$result[ $sent_key ][( string )( $char_idx + 1 )] = $ch;
			}
		}
	}

    return $result;
}
?>