<?php
/*
php H:\github\CanonicalTextTrees\tools\php\test_add_node.php
 */
declare(strict_types=1);
require_once( 
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	'php' . DIRECTORY_SEPARATOR .
	'lib' . DIRECTORY_SEPARATOR .
	 '函式.php' );
require_once( 
	__DIR__ . DIRECTORY_SEPARATOR .
	 'functions.php' );

$tree = 提取基準正文樹( '0003' );
//add_node( $tree, explode( ',','0003,6,1' ), 5, 
add_node( $tree, array(), 0, 
	array( '9'=>'。' ) );
print_r( $tree );

function add_node(
	array &$tree, // the canonical text tree
	array $path,  // path to the parent node; empty array means root
	int $pos,     // 0-based position to insert node
	array $node   // exactly one child node to insert
) : void
{
	if(count($node) !== 1)
	{
		throw new InvalidArgumentException(
			'Parameter $node must contain exactly one child node.'
		);
	}

	$pointer = &$tree;

	// navigate to the parent node
	foreach($path as $segment)
	{
		if(!is_array($pointer))
		{
			throw new InvalidArgumentException(
				'Invalid path: encountered a non-array node before reaching target parent.'
			);
		}

		if(!array_key_exists($segment, $pointer))
		{
			throw new InvalidArgumentException(
				'Invalid path: segment "' . (string)$segment . '" does not exist.'
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

	$child_count = count($pointer);

	if($pos < 0 || $pos > $child_count)
	{
		throw new OutOfRangeException(
			'Parameter $pos is out of range.'
		);
	}

	$new_key = array_key_first($node);

	if($new_key === null)
	{
		throw new InvalidArgumentException(
			'Parameter $node must not be empty.'
		);
	}

	if(array_key_exists($new_key, $pointer))
	{
		throw new InvalidArgumentException(
			'Duplicate child key "' . (string)$new_key . '".'
		);
	}

	$before = array_slice($pointer, 0, $pos, true);
	$after  = array_slice($pointer, $pos, null, true);

	$pointer = $before + $node + $after;
}
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
?>
