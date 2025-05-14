<?php
include('FomaInterface.php');
$morphology = new FomaTransducer('HurFST/Morphology/Morphology.foma');
$segmentation = new FomaTransducer('HurFST/Segmentation/Segmentation.foma');
$extSegm = new FomaTransducer(
	'HurFST/ExtendedSegmentation/ExtendedSegmentation.foma'
);
?>
