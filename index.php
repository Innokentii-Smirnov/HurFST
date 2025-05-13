<?php
include('FomaInterface.php');
$morphology = new FomaTransducer('HurFST/Morphology/Morphology.foma');
$segmentation = new FomaTransducer('HurFST/Segmentation/Segmentation.foma');
$extSegm = new FomaTransducer(
	'HurFST/ExtendedSegmentation/ExtendedSegmentation.foma'
);
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
	$word = $_GET['word'];
	switch ($transducerName)
	{
		case 'analysis':
			$transducer = $morphology;
		case 'segmentation':
			$transducer = $segmentation;
		case 'extendedSegmentation':
			$transducer = $extSegm;
	}
	$result = $transducer->analyze($word);
	echo $result;
}
?>
