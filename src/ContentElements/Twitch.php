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
		$this->referenzen = unserialize($this->referenzen);
		return parent::generate(); 
	}

	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		$daten = array();
		$i = 0;
		foreach($this->referenzen as $item)
		{
			if($item['active'])
			{
				$i++;
				$daten[] = array
				(
					'nummer' => $i,
					'text'   => $item['url'] ? '<a href="'.$item['url'].'"'.($item['target'] ? ' target="_blank"' : '').'>'.$item['text'].'</a>' : $item['text']
				);
			}
		}

		$this->Template->Twitch = $daten;
		$this->Template->headline = $this->headline ? $this->headline : ($i == 1 ? $GLOBALS['TL_LANG']['tl_content']['Twitch_headline_singular'] :  $GLOBALS['TL_LANG']['tl_content']['Twitch_headline_plural']);
	}
}
