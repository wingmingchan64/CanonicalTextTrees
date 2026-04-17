<?php
/*
php H:\github\CanonicalTextTrees\tools\php\bin\test_add_node.php
 */
declare( strict_types = 1 );
require_once( 
	dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );
require_once( 
	dirname( __DIR__, 1 ) . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 'functions.php' );

$tree = 提取基準正文樹( '0003' );
//add_node( $tree, explode( ',','0003,6,1' ), 5,
add_punctuation( $tree );
//add_node( $tree, array(), 0, array( '9'=>'。' ) );
//print_r( $tree );
echo 攤平樹文字_略過鍵( $tree, array( '詩題' ) );

/*

function add_node_before(
	array &$tree,
	array $path,        // path to parent node
	string $siblingKey, // existing child key
	array $node         // new node (single entry)
) : void
{
	$pointer = &$tree;

	// navigate to parent
	foreach($path as $segment)
	{
		if(!is_array($pointer) || !array_key_exists($segment, $pointer))
		{
			throw new InvalidArgumentException(
				'Invalid path.'
			);
		}
		$pointer = &$pointer[$segment];
	}

	if(!is_array($pointer))
	{
		throw new InvalidArgumentException(
			'Target parent node must be an array.'
		);
	}

	$keys = array_keys($pointer);
	$pos = array_search($siblingKey, $keys, true);

	if($pos === false)
	{
		throw new InvalidArgumentException(
			'Sibling key "' . $siblingKey . '" not found.'
		);
	}

	add_node($tree, $path, $pos, $node);
}

function add_node_after(
	array &$tree,
	array $path,
	string $siblingKey,
	array $node
) : void
{
	$pointer = &$tree;

	// navigate to parent
	foreach($path as $segment)
	{
		if(!is_array($pointer) || !array_key_exists($segment, $pointer))
		{
			throw new InvalidArgumentException(
				'Invalid path.'
			);
		}
		$pointer = &$pointer[$segment];
	}

	if(!is_array($pointer))
	{
		throw new InvalidArgumentException(
			'Target parent node must be an array.'
		);
	}

	$keys = array_keys($pointer);
	$pos = array_search($siblingKey, $keys, true);

	if($pos === false)
	{
		throw new InvalidArgumentException(
			'Sibling key "' . $siblingKey . '" not found.'
		);
	}

	add_node($tree, $path, $pos + 1, $node);
}
*/
?>
