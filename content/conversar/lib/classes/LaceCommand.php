<?php
class LaceCommand
{
	var $tokens = array();
	var $message;

	function init($message)
	{
		$this->message = $message;
		$this->tokenize();
		return $this->performCommand();
	}

	function tokenize()
	{
		$this->tokens = explode(' ', $this->message->text);
	}

	function performCommand()
	{
		return $this->message;
	}

	function getHelpDisplay()
	{
		return array
		(
			'title'       => 'Lace Command',
			'commands'    => array('/command1', '/command2'),
			'usage'       => '/command1 <parameter>',
			'description' => 'This is a generic Lace command.'
		);
	}
}
?>