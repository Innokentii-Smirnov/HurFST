<?php
function findBoundary($word)
{
	for ($i = 0; $i < strlen($word); $i++)
	{
		$char = $word[$i];
		if ($char === '-' || $char === '=' || $char === '.')
		{
			return $i;
		}
	}
	return -1;
}
function getTag($analysis)
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
	return $tag;
}
function parseAnalysis($analysis)
{
	$index = findBoundary($analysis);
	if ($index !== -1)
	{
		$lex = substr($analysis, 0, $index);
		if ($analysis[$index] === '-')
		{
			$index++;
		}
		$tag = substr($analysis, $index);
	}
	else
	{
		$lex = $analysis;
		$tag = '';
	}
	$exploded = explode(',', $lex);
	if (count($exploded) !== 2)
	{
		throw new Error('Lexical entry had incorrect format: '.$lex);
	}
	list($stem, $pos) = $exploded;
	return array($stem, $pos, $tag);
}
?>
