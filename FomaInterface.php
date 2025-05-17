<?php
class FomaTransducer
{
	private string $binaryPath;
	function __construct($transducerPath, $compile=false, $verbose=false)
	{
		$directory = dirname($transducerPath);
		$name = basename($transducerPath, '.foma');
		$this->binaryPath = realpath($directory).DIRECTORY_SEPARATOR.$name.'.bin';
		$oldDir = getcwd();
		if (!file_exists($this->binaryPath) || $compile) {
			chdir($directory);
			$result = `foma -e "source $name.foma" -e "push $name" -e "save stack $name.bin" -e "exit"`;
			if ($verbose) {
				echo $result;
			}
			chdir($oldDir);
		}
	}
	function analyze($word)
	{
		$analysis = `echo "$word" | flookup -w "" -x $this->binaryPath`;
		if (is_null($analysis))
		{
			throw new Exception(sprintf(
				'Transducer %s returned null on word %s.',
				$this->binaryPath, $word
			));
		}
		return array_unique(explode("\n", rtrim($analysis)));
	}
	function generate($analysis)
	{
		$word = `echo "$analysis" | flookup -i -w "" -x $this->binaryPath`;
		return array_unique(explode("\n", rtrim($word)));
	}
}
?>
