<?php
class LaceTextFilter
{
	var $text;

	function init($text)
	{
		$this->text = $text;
		return $this->performTextFilter();
	}

	function performTextFilter()
	{
		return $this->text;
	}
}
?>