<?php
/**
 * @package API plugins
 * @copyright Copyright (C) 2009 2014 Techjoomla, Tekdi Technologies Pvt. Ltd. All rights reserved.
 * @copyright Copyright 2016 IRD Entropie. All rights reserved
 * @license GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
*/

defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.plugin.plugin');

class plgAPIRestcot extends ApiPlugin
{
	public function __construct(&$subject, $config = array())
	{
		parent::__construct($subject, $config = array());

		ApiResource::addIncludePath(dirname(__FILE__).'/restcot');


		$app = JFactory::getApplication();
		$app->setHeader('Access-Control-Allow-Origin','*');
        $app->setHeader('Access-Control-Allow-Methods','POST, GET');
        $app->setHeader('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept');
		$app->sendHeaders();
	}
}
