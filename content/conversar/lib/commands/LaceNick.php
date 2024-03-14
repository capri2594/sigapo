<?php

$laceCommand = 'LaceNick';
$laceCommandListeners = array
	(
		'/nick',
		'/name'
	);

class LaceNick extends LaceCommand
{
	function performCommand()
	{
		global $A;

		array_shift($this->tokens);

		$newName = join(' ', $this->tokens);

		if ($A->keyExists($newName))
			return false;

		$newName = trimName($newName);
		$cleanName = setName($newName);

		$this->message->text = 'is now <strong>'.$cleanName.'</strong>';
		$this->message->type = LACE_NICK_MESSAGE;

		$A->changeName($this->message->name, $newName);

		return $this->message;
	}

	function getHelpDisplay()
	{
		return array
		(
			'title'   	 => 'Nickname',
			'commands'	 => array('/nick', '/name'),
			'usage'       => '/nick <nickname>',
			'description' => 'Use this command to change your nickname.'
		);
	}
}

?>