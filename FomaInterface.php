<?php
include('Process.php');
class FomaTransducer
{
	private string $binaryPath;
	private string $sep;
	private Process $flookupProcess;
	function __construct($transducerPath, $compile=true, $verbose=false, $forGeneration=false, $sep=';')
	{
		$directory = dirname($transducerPath);
		$name = basename($transducerPath, '.foma');
		$this->binaryPath = realpath($directory).DIRECTORY_SEPARATOR.$name.'.bin';
		$this->sep = $sep;
		$oldDir = getcwd();
		if ($compile && !file_exists($this->binaryPath)) {
			chdir($directory);
			$result = `foma -e "source $name.foma" -e "push $name" -e "save stack $name.bin" -e "exit"`;
			if ($verbose) {
				echo $result;
			}
			chdir($oldDir);
		}
		$option = $forGeneration ? '-i' : '';
		$args = "-b {$option} -w \"{$sep}\" -x {$this->binaryPath}";
		$this->flookupProcess = new Process('flookup', $args, $sep);
	}
	function apply($word)
	{
		$this->flookupProcess->write($word);
		$result = $this->flookupProcess->read();
		return $result;
	}
}
?>
