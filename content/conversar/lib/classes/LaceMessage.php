<?php
class LaceMessage
{
	var $name;
	var $text;
	var $type;
	var $time;

	function LaceMessage($name = '', $text = '', $time = 0, $type = LACE_TEXT_MESSAGE)
	{
		$this->name = $name;
		$this->text = $text;
		$this->time = $time === 0 ? time() : $time;
		$this->type = $type;
	}

	function toHTML($prevName = false, $prevType = false)
	{
		$classes = array();

		switch ($this->type)
		{
			case LACE_TEXT_MESSAGE: $classes[] = 'text-message'; break;
			case LACE_ACTN_MESSAGE: $classes[] = 'action-message'; break;
			case LACE_TIME_MESSAGE: $classes[] = 'time-message'; break;
			case LACE_DATE_MESSAGE: $classes[] = 'date-message'; break;
			case LACE_JOIN_MESSAGE: $classes[] = 'join-message'; break;
			case LACE_PART_MESSAGE: $classes[] = 'part-message'; break;
			case LACE_KICK_MESSAGE: $classes[] = 'kick-message'; break;
			case LACE_IDLE_MESSAGE: $classes[] = 'idle-message'; break;
			case LACE_NICK_MESSAGE: $classes[] = 'nick-message'; break;
		}

		if ($this->type == LACE_TEXT_MESSAGE && $this->name === sessionVar('name'))
			$classes[] = 'user-message';

		if ($this->type == LACE_TEXT_MESSAGE && $prevName == $this->name && $prevType == $this->type)
			$classes[] = 'followup-message';

		$classes = join(' ', $classes);

		$name = mb_htmlentities($this->name);

		$time = date('H:i', getLocalTime($this->time));
		$html = <<<HTML
		<tr class="{$classes}">
		  <td class="name" title="{$time}"><span>{$name}</span></td>
		  <td class="text"><span>{$this->text}</span></td>
		</tr>

HTML;
		return $html;
	}
}
?>