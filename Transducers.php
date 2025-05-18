<?php
include('FomaInterface.php');
include('common.php');

class TransducerSystem
{
	private string $postfix;
	private FomaTransducer $morphology;
	private FomaTransducer $segmentation;
	private FomaTransducer $extSegm;
	function __construct($postfix='')
	{
		$this->postfix = $postfix;
		$this->morphology = new FomaTransducer(
			'HurFST/Morphology/Morphology'.$postfix.'.foma'
		);
		$this->segmentation = new FomaTransducer(
			'HurFST/Segmentation/Segmentation'.$postfix.'.foma'
		);
		$this->extSegm = new FomaTransducer(
			'HurFST/ExtendedSegmentation/ExtendedSegmentation'.$postfix.'.foma'
		);
	}
	function apply($word)
	{
		$segmentations = $this->segmentation->analyze($word);
		if ($segmentations[0] === '+?')
		{
			$segmentations = $this->extSegm->analyze($word);
		}
		$answers = Array();
		foreach ($segmentations as $segmentation)
		{
			$analyses = $this->morphology->analyze($segmentation);
			if ($analyses[0] !== '+?')
			{
				foreach ($analyses as $analysis)
				{
					list($stem, $pos, $tag) = parseAnalysis($analysis);
					$answer = $segmentation.' @  @ '.$tag.' @ '.strtolower($pos).' @ ';
					$answers[] = $answer;
				}
			}
			else
			{
				$answer = $segmentation.' @  @  @ unk @ ';
				$answers[] = $answer;
			}
		}
		return $answers;
	}
}
?>
