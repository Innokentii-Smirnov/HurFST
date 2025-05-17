<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/plain');
include_once('Transducers.php');
$transducerSystem = new TransducerSystem;
if (!array_key_exists('word', $_GET))
{
	echo 'No input word provided.';
}
else
{
	$word = urldecode($_GET['word']);
	$result = $transducerSystem->apply($word);
	echo implode("\n", $result);
}
?>
