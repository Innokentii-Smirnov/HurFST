<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/plain');
include('FomaInterface.php');
include('common.php');
$morphology = new FomaTransducer(
	'HurFST/Morphology/Morphology.foma'
);
$morphologyOov = new FomaTransducer(
	'HurFST/Morphology/MorphologyOov.foma'
);
if (!array_key_exists('word', $_GET))
{
	echo 'No input word provided.';
}
else
{
	$word = urldecode($_GET['word']);
	$result = $morphology->analyze($word);
	if (substr($result[0], 0, 2) === '+?')
	{
		$result = $morphologyOov->analyze($word);
		if (substr($result[0], 0, 2) === '+?')
		{
			$result = Array();
		}
	}
	echo implode("\n", $result);
}
?>
