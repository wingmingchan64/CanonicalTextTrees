<?php
/*
php H:\github\CanonicalTextTrees\tools\php\test_text_retrieval.php
 */
declare( strict_types = 1 );
// load constants
require_once( __DIR__ . DIRECTORY_SEPARATOR . '常數.php' );
// load exceptions
require_once( __DIR__ . DS . 'autoload.php' );

define( 'REGISTRY_PATH', dirname( __FILE__, 4 ) . 
	DIRECTORY_SEPARATOR .
	'schemas' . DIRECTORY_SEPARATOR . 
	'json' . DIRECTORY_SEPARATOR . 
	'registry' . DIRECTORY_SEPARATOR );

// load registry
$registry = json_decode(
	file_get_contents( 
		REGISTRY_PATH . 'registry.json' ), true );
	
$異體字 = json_decode(
	file_get_contents(
		REGISTRY_PATH . '異體字.json' ), true );
// load functions
$func_dir = __DIR__ . DS . FUNCTIONS_DIR;

if( !is_dir( $func_dir ) )
{
    throw new RuntimeException( '函式目錄不存在: ' . $func_dir );
}
$files = scandir( $func_dir );
sort( $files, SORT_STRING );

foreach( $files as $file )
{
	$path = $func_dir . $file;

	if(
		is_file( $path )
		&& preg_match( '/\.php$/i', $file )
	)
	{
		require_once( $path );
	}
}

function retrieve_text_from_canonical_tree(
	string $path ) : string
{
	$parts = explode( ',', $path );
	$work_id = $parts[ 0 ];
	
	if( !is_legal_path( $parts[ 0 ], $path ) )
	{
		throw new CTT\Exceptions\IllegalCoordinateException( $path . " not a legal path." );
	}
	global $registry;
	
	$tree_path = dirname( __FILE__, 4 ) . 	
		DIRECTORY_SEPARATOR .
		get_title( $work_id ) .
		DIRECTORY_SEPARATOR .
		'trees' . DIRECTORY_SEPARATOR . 
		$parts[ 1 ] . '.json';
	
	$tree = json_decode(
		file_get_contents( $tree_path ), true );
	$pointer = $tree;
	
	for( $i = 1; $i < count( $parts ) - 1; $i++ )
	{
		$pointer = $pointer[ $parts[ $i ] ];
	}

	return  flatten_tree_to_text_skip_keys( [ $pointer ] );;
}

/**
 * 攤平樹為文字，可略過指定 key。
 *
 * @param mixed $node
 * @param array $skip_keys
 * @return string
 * @throws InvalidArgumentException
 */
function flatten_tree_to_text_skip_keys(
	mixed $node, array $skip_keys = [] ): string
{
	if( is_string( $node ) )
	{
		return $node;
	}

	if(!is_array($node))
	{
		throw new InvalidArgumentException(
			'Tree node must be either string or array.'
		);
	}

	$text = '';

	foreach( $node as $key => $child )
	{
		if( in_array( ( string )$key, $skip_keys, true ) )
		{
			continue;
		}

		$text .= flatten_tree_to_text_skip_keys($child, $skip_keys);
	}

	return $text;
}

function build_text_tree(
	string $txt,
	string $title
) : array
{
	$paragraphs = preg_split("/\R\R/u", $txt);
		
	$t = trim( $paragraphs[ 0 ] );
	
	$tree = [
		$title => $t
    ];
	populate_hongloumeng_tree( $paragraphs, $tree );
	
	return $tree;
}

function build_hongloumeng_tree(
	string $txt
) : array
{
	$paragraphs = preg_split("/\R\R/u", $txt);
		
	// first paragraph is 回目
	$回目 = trim( $paragraphs[ 0 ] );
	
	$tree = [
		回目 => $回目
    ];
	populate_hongloumeng_tree( $paragraphs, $tree );
	
	return $tree;
}


function build_lunyu_tree(
	string $txt
) : array
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

function build_ci_tree(
	string $txt
) : array
{
	$lines = preg_split("/\R/u", $txt);
		
	if ( !$lines )
	{
		//continue;
	}
	// first line is 蘇軾 水調歌頭
	$header = trim( $lines[ 0 ] );
	$header_parts = 
		preg_split( '/\s+/u', $header, 2 );
	$作者 = $header_parts[ 0 ] ?? '';
	$詞牌 = $header_parts[ 1 ] ?? '';
	
	$tree = [
		作者 => $作者,
		詞牌 => $詞牌
    ];
	populate_tree( $lines, $tree );
	
	/*
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
    }*/
	return $tree;
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

function populate_hongloumeng_tree(
	array $paragraphs, array &$tree ) : void
{
	//$counter = 0;
	
	for( $i = 1; $i < count( $paragraphs ); $i++ )
    {
        $paragraph_no = $i + 1;
        $paragraph = trim( $paragraphs[ $i ] );

        if( !preg_match( "/\R/u", $paragraph ) )
        {
			$tree[ (string)$paragraph_no ] =
					line_to_sentence_tree( $paragraph );
        }
		else
		{
			$line_no = 0;
			$lines = preg_split( "/\R/u", $paragraph );
			
			foreach( $lines as $line )
			{
				$line_no++;
				$tree[ ( string )$paragraph_no ]
					[ (string)$line_no ] =
					line_to_sentence_tree( $line );
			}
		}
    }
}


function build_tree_corpus(
    string $txt_dir,
    string $tree_dir,
    array $group_map
): void
{
    if ( !is_dir( $tree_dir ) )
    {
        mkdir( tree_dir, 0777, true );
    }

    $files = glob( $txt_dir . '/*.txt' );

    foreach ( $files as $file )
    {
        $txt = file_get_contents( $file );
        $lines = preg_split("/\R/u", $txt);
		
        if ( !$lines )
        {
            continue;
        }

		// first line is 424-001 白居易 賀雨
        $header = trim( $lines[ 0 ] );
        $header_parts = 
			preg_split( '/\s+/u', $header, 3 );
        $doc_id = $header_parts[ 0 ] ?? '';

        if ($doc_id === '')
        {
            continue;
        }

        // 判斷是否組詩
        if ( isset( $group_map[ $doc_id ] ) )
        {
            write_member_tree_files(
                $txt,
                $group_map,
                $tree_dir
            );
        }
        else
        {
            write_single_tree_file(
                $txt,
                $tree_dir
            );
        }

        echo "Processed: $doc_id\n";
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

function write_member_tree_files(
	string $txt, 
	array $group_map, 
	string $output_dir ): array
{
    $lines = preg_split( "/\R/u", $txt );

    if ( !$lines || count( $lines ) === 0 )
    {
        return [];
    }

    $header = trim( $lines[ 0 ] );
    $header_parts = preg_split( '/\s+/u', $header, 3 );
    $doc_id = $header_parts[ 0 ] ?? '';

    if ( $doc_id === '' || !isset(
		$group_map[ $doc_id ] ) )
    {
        return [];
    }

    $info = $group_map[$doc_id];
    $subtitle_lines = [];

    foreach( $info as $poem_no => $value )
    {
		// 組詩樹沒有詩題
        if ( $poem_no === 詩題 )
        {
            continue;
        }

		// 副題
        foreach( $value as $line_no => $subtitle )
        {
			print_r( $value );
            $subtitle_lines[ (int)$poem_no ] = [
                'line' => (int)$line_no,
                'subtitle' => $subtitle
            ];
        }
    }

    ksort( $subtitle_lines );

    $poem_numbers = array_keys( $subtitle_lines );
    $poem_count = count( $poem_numbers );

    $ranges = [];

    for( $i = 0; $i < $poem_count; $i++ )
    {
        $poem_no = $poem_numbers[ $i ];
        $start = $subtitle_lines[ $poem_no ][ 'line' ] + 1;

        if( $i + 1 < $poem_count )
        {
            $next = $poem_numbers[ $i + 1 ];
            $end = $subtitle_lines[ $next][ 'line' ] - 1;
        }
        else
        {
            $end = count( $lines );
        }

        $member_doc_id = $doc_id . '-' . $poem_no;

        $ranges[ $member_doc_id ] = [
            'start' => $start,
            'end' => $end,
            'subtitle' => 
				$subtitle_lines[ $poem_no ][ 'subtitle' ]
        ];
    }

    $trees = [];

    foreach( $ranges as $member_doc_id => $r )
    {
        $trees[$member_doc_id] = [
            副題 => $r[ 'subtitle' ]
        ];
    }

    for( $i = 1; $i < count($lines); $i++ )
    {
        $line_no = $i + 1;
        $line = trim( $lines[$i] );

        if( $line === '' )
        {
            continue;
        }

        foreach( $ranges as $member_doc_id => $r )
        {
            if($line_no < $r['start'] || $line_no > $r['end'] )
            {
                continue;
            }

            if( $line === $r['subtitle'] )
            {
                continue;
            }

            $trees[ $member_doc_id ][ (string)$line_no ] =
                line_to_sentence_tree( $line );

            break;
        }
    }

    if(!is_dir($output_dir))
    {
        mkdir($output_dir, 0777, true);
    }

    $written = [];

    foreach( $trees as $member_doc_id => $tree )
    {
        $path = $output_dir . '/' . $member_doc_id . '.json';

        file_put_contents(
            $path,
            json_encode(
				$tree, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );

        $written[] = $path;
    }

    return $written;
}

function write_single_tree_file(
	string $txt, 
	string $output_dir): ?string
{
    $lines = preg_split( "/\R/u", $txt );

    if ( !$lines || count( $lines ) === 0 )
    {
        return null;
    }

    $header = trim( $lines[0] );
    $header_parts = preg_split( '/\s+/u', $header, 3 );

	// first line is 424-001 白居易 賀雨
    $doc_id = $header_parts[ 0 ] ?? '';
	$author = $header_parts[ 1 ] ?? '';
    $title = $header_parts[ 2 ] ?? '';

    if( $doc_id === '' )
    {
        return null;
    }

    $tree = [
		作者 => $author,
        詩題 => $title
    ];

    for( $i = 1; $i < count($lines); $i++ )
    {
        $line_no = $i + 1;
        $line = trim( $lines[$i] );

        if( $line === '' )
        {
            continue;
        }

        $tree[(string)$line_no] = line_to_sentence_tree($line);
    }

    if( !is_dir($output_dir ) )
    {
        mkdir($output_dir, 0777, true);
    }

    $path = $output_dir . '/' . $doc_id . '.json';

    file_put_contents(
        $path,
        json_encode(
			$tree, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
    );

    return $path;
}
?>