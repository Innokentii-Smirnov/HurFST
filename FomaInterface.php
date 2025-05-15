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
		return $analysis;
	}
	function generate($analysis)
	{
		$word = `echo "$analysis" | flookup -i -w "" -x $this->binaryPath`;
		return $word;
	}
}
?>
