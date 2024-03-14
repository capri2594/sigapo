<?php

$laceCommand = 'LaceExit';
$laceCommandListeners = array
	(
	 	'/part',
	 	'/exit',
	 	'/quit',
	 	'/leave'
	);

class LaceExit extends LaceCommand
{
	function performCommand()
	{
		global $A;

		array_shift($this->tokens);
		$exitMessage = join(' ', $this->tokens);
		$this->message->type = LACE_PART_MESSAGE;
		$this->message->text = 'has left the room.';
		if ($exitMessage != "")
			$this->message->text .= ' ('.$exitMessage.')';

		return $this->message;
	}

	function getHelpDisplay()
	{
		return array(
			'title'   	 => 'Exit',
			'commands'	 => array('/part', '/exit', '/quit', '/leave'),
			'usage'       => '/part [<message>]',
			'description' => 'Use this command to leave the room with an optional message.'
		);
	}

}
?>
