<?php

$laceTextFilter = 'LaceLinkFilter';
$filterPriority = 100;

class LaceLinkFilter extends LaceTextFilter
{
	var $urlRegex;
	var $linkRegex;

	function performTextFilter()
	{
		$this->urlRegex  = "\b((https?|ftp)://)?([a-z0-9](?:[-a-z0-9@]*[a-z0-9])?\.)+(com\b|edu\b|biz\b|gov\b|in(?:t|fo)\b|mil\b|net\b|org\b|[a-z][a-z]\b)(:d+)?(/[-a-z0-9_:@&?=+,.!/~*'\%\$]*)*(?<![.,?!])(?!((?!(?:<a )).)*?(?:</a>))";
		$this->linkRegex = "\[(".$this->urlRegex.")\|(.*?)\]";

		$this->filterLinkSyntax();
		$this->filterBareUrls();

		return $this->text;
	}

	function filterLinkSyntax()
	{
		$text = $this->text;
		$search = array();
		$replace = array();

		$matches = $this->getMatches("%".$this->linkRegex."%ix", $text);

		if ($matches)
		{
			$i = 0;
			foreach ($matches[0] as $match)
			{
				$url  = $matches[1][$i];
				$text = $matches[9][$i];

				$http = mb_substr($url, 0, 4);
				if ($http !== 'http' && $http !== 'ftp:')
					$url = 'http://'.$url;

				$search[] = $match;
				$replace[] = $this->makeLink($url, $text);

				$i++;
			}

			$text = str_replace($search, $replace, $this->text);
		}

		$this->text = $text;

	}

	function filterBareUrls()
	{
		$text = $this->text;
		$search = array();
		$replace = array();

		$matches = $this->getMatches("%".$this->urlRegex."%ix", $text);

		if ($matches)
		{
			foreach ($matches[0] as $text)
			{
				$link = $text;
				$http = mb_substr($text, 0, 4);
				if ($http !== 'http' && $http !== 'ftp:')
					$link = 'http://'.$text;

				$search[] = $text;
				$replace[] = $this->makeLink($link, $text);
			}

			$text = str_replace($search, $replace, $this->text);
		}

		$this->text = $text;
	}

	function getMatches($regex, $text)
	{
		$numMatches = preg_match_all($regex, $text, $matches);

		return ($numMatches > 0 ) ? $matches : false;
	}

	function makeLink($url, $text)
	{
		return '<a href="'.$url.'" target="_blank" rel="external nofollow" class="external">'.$text.'</a>';
	}
}