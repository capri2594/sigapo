<?php

$laceCommand = 'LaceAction';
$laceCommandListeners = array
	(
	 	'/me'
	);

class LaceAction extends LaceCommand
{
	function performCommand()
	{
		array_shift($this->tokens);
		$this->message->text = join(' ', $this->tokens);
		$this->message->type = LACE_ACTN_MESSAGE;

		return $this->message;
	}

	function getHelpDisplay()
	{
		return array(
			'title'   		=> 'Action',
			'commands'		=> array('/me'),
			'usage'       => '/me <action>',
			'description' => 'Use this command to perform an \'action.\''
		);
	}

}

?>