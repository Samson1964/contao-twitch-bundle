<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2017 Leo Feyer
 *
 * PHP version 5
 * @copyright  Frank Hoppe
 * @author     Frank Hoppe
 * @package    Twitch
 * @license    LGPL
 * @filesource
 */

namespace Schachbulle\ContaoTwitchBundle\ContentElements;

/**
 * Class Reference
 *
 */
class Twitch extends \ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_twitch';

	public function generate()
	{
		if($this->twitchOptions) $this->twitchOptions = unserialize($this->twitchOptions);
		$this->twitchOptions = array();

		$this->playerSize = unserialize($this->playerSize);
		return parent::generate();
	}

	/**
	 * Generate the content element
	 */
	protected function compile()
	{

		// Zufallszahl für Container-ID ermitteln
		$container_id = mt_rand();
		// Reponsive-Ratio übergeben, wenn gewünscht
		if($this->playerAspect)
		{
			$responsive = 'responsive ratio-'.str_replace(':', '', $this->playerAspect);
		}
		else
		{
			$responsive = '';
		}

		$content = '';
		//$content .= '<script src= "https://player.twitch.tv/js/embed/v1.js"></script>'."\n";
		$content .= '<div class="'.$responsive.'" id="twitch_'.$container_id.'"></div>'."\n";
		$content .= '<script type="text/javascript">'."\n";
		$content .= '  var options = {'."\n";
		// Breite setzen
		if($this->playerSize[0])
		{
			$content .= '    width: '.$this->playerSize[0].','."\n";
		}
		else
		{
			$content .= '    width: 400,'."\n";
		}
		// Höhe setzen
		if($this->playerSize[1])
		{
			$content .= '    height: '.$this->playerSize[1].','."\n";
		}
		else
		{
			$content .= '    height: 300,'."\n";
		}
		$content .= '    autoplay: '.(in_array('twitch_autoplay', $this->twitchOptions) ? 'true' : 'false').','."\n";
		$content .= '    video: "'.$this->twitch.'",'."\n";
		// Startzeit setzen
		if($this->playerStart > 0)
		{
			$startzeit = self::Zeitrechner($this->playerStart);
			$content .= '    time: "'.$startzeit.'",'."\n";
		}
		$content .= '    parent: ["'.$_SERVER['SERVER_NAME'].'"]'."\n";
		$content .= '  };'."\n";
		$content .= '  var player = new Twitch.Player("twitch_'.$container_id.'", options);'."\n";
		$content .= '  player.setVolume(0.5);'."\n";
		$content .= '</script>'."\n";

		$this->Template->twitchcontainer = $content;

	}

	/**
	 * Rechnet die Sekunden in einen String im Twitch-Format um: 0h0m0s
	 */
	function Zeitrechner($sekunden)
	{

		$sek = $sekunden % 60;
		$min = (($sekunden - $sek) / 60) % 60;
		$std = (((($sekunden - $sek) /60)- $min) / 60) % 24;

		return $std.'h'.$min.'m'.$sek.'s';
	}
}
