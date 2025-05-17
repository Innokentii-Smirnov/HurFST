<?php
include('FomaInterface.php');
function findBoundary($word)
{
	for ($i = 0; $i < strlen($word); $i++)
	{
		$char = $word[$i];
		if ($char === '-' || $char === '=' || $char === '')
		{
			return $i;
		}
	}
	return -1;
}
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
			foreach ($analyses as $analysis)
			{
				$index = findBoundary($analysis);
				if ($index !== -1)
				{
					if ($analysis[$index] === '-')
					{
						$index++;
					}
					$tag = substr($analysis, $index);
				}
				else
				{
					$tag = '';
				}
				$answer = $segmentation.' @  @ '.$tag.' @ '.$this->postfix.' @ ';
			}
			$answers[] = $answer;
		}
		return $answers;
	}
}
?>
