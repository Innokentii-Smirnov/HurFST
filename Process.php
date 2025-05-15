<?php
class Process
{
	private string $sep;
	private $process;
	private array $pipes;
	function __construct($name, $args, $sep)
	{
		$this->sep = $sep;
		$descriptorspec = array(
			0 => array("pipe", "r"),
			1 => array("pipe", "w"),
			2 => array("file", "error-output.txt", "w")
		);
		$this->process = proc_open($name.' '.$args, $descriptorspec, $pipes);
		$this->pipes = $pipes;
	}
	function write($input)
	{
		fwrite($this->pipes[0], $input."\n");
	}
	function read()
	{
		$contents = stream_get_line($this->pipes[1], 0, $this->sep);
		return $contents;
	}
	function __destruct()
	{
		proc_close($this->process);
	}
}
?>
