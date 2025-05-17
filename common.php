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
?>
