<?php
header('Access-Control-Allow-Origin: *');
include_once('Transducers.php');
if (!array_key_exists('fst', $_GET))
{
	echo 'No FST specified.';
}
else if (!array_key_exists('word', $_GET))
{
	echo 'No input word provided.';
}
else
{
	$transducerName = $_GET['fst'];
	$word = urldecode($_GET['word']);
	switch ($transducerName)
	{
		case 'analysis':
			$transducer = $morphology;
			break;
		case 'segmentation':
			$transducer = $segmentation;
			break;
		case 'extendedSegmentation':
			$transducer = $extSegm;
			break;
	}
	$result = $transducer->analyze($word);
	echo $result;
}
?>
