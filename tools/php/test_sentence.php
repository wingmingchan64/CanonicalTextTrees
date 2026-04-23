<?php
/*
php H:\github\CanonicalTextTrees\tools\php\test_sentence.php
 */

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

$text = <<<'EOD'
Whatever weird effect was blocking it isn’t anymore.”
“How did you do it? What killed it?”
“I penetrated the outer cell membrane with a nanosyringe.”
“You poked it with a stick?”
“No!” I said. “Well. Yes. But it was a scientific poke with a
very scientific stick.”
“It took you two days to think of poking it with a stick.”
“You…be quiet.”
EOD;

$iterator = IntlBreakIterator::createSentenceInstance('en_US');
$iterator->setText($text);

$sentences = [];
$start = 0;
foreach ($iterator as $boundary) {
    $sentences[] = substr($text, $start, $boundary - $start);
    $start = $boundary;
}
print_r($sentences);

$sentence = "“It took you two days to think of poking it with a stick.”";

$words = preg_split('/(\W)/u', $sentence, -1,  PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
//print_r($words);
$temp = [];

foreach( $words as $word )
{
	$word = trim( $word );
	if( $word != "" )
		$temp[] = $word;
}
print_r($temp);
?>