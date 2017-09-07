<?php
/**
 * @package    Com_Api
 * @copyright  Copyright (C) 2009-2014 Techjoomla, Tekdi Technologies Pvt. Ltd. All rights reserved.
 * @copyright  Cpŷright 2016 IRD / UMR Entropie / OREANET / GOPS
 * @license    GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 */
defined('_JEXEC') or die( 'Restricted access' );
require_once JPATH_ADMINISTRATOR . '/components/com_cot_forms/models/cot_admins.php';
jimport('joomla.plugin.plugin');
jimport('joomla.html.html');
//JLoader::register('JCategoryNode', JPATH_BASE . '/libraries/legacy/categories/categories.php');
JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_cot_forms/models');


class RestcotApiResourceRestcot extends ApiResource
{
	public function get()
	{
		$this->plugin->setResponse($this->getCotAdminList());
	}

	public function delete()
	{
		$this->plugin->setResponse('in delete');
	}
	public function post()
	{
		$this->plugin->setResponse($this->CreateUpdateCotAdmin());
	}

	public function getCotAdmin()
	{
		self::getListQuery();
	}

	/**
	 * Get the master query for retrieving a list of CotAdmin to the model state.
	 *
	 * @return  JDatabaseQuery
	 *
	 * @since   1.6
	 */
	public function getCotAdminList()
	{
		JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_cot_forms/models', 'Cot_formsModelCot_admins');
        	$model = JModelLegacy::getInstance('Cot_formsModelCot_admins');
        	$cotadmins = $model->getItems();
        	return $this->json_encode_objs($cotadmins);
		
	}

	public function json_encode_objs($item)
    	{
        	if(!is_array($item) && !is_object($item)) 
		{
            		return json_encode($item, JSON_HEX_TAG);
        	} else {
            		$pieces = array();
            		foreach($item as $k=>$v)
			{
                		$pieces[] = "\"$k\":".$this->json_encode_objs($v);
            		}
            		return '{'.implode(',',$pieces).'}';
        	}
    	}

	/**
	 * CreateUpdateCotAdmin is to create / update CotAdmin
	 *
	 * @return  Bolean
	 *
	 * @since  3.5
	 */
	public function CreateUpdateCotAdmin()
	{

		if (version_compare(JVERSION, '3.0', 'lt'))
		{
			JTable::addIncludePath(JPATH_PLATFORM . 'joomla/database/table');
		}
		
		$obj = new stdclass;

                $app = JFactory::getApplication();
                $jinput = $app->input;
		
                if (trim($jinput->json->get('observer_name', '', 'STRING'))==false)
                {
						$obj->status = 0;
                        $obj->code = 'ER001';
                        $obj->message = 'Observer name is Missing';
                        return $obj;
                }

             
			JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_cot_forms/tables', 'Cot_formsTablecot_Admin');

            $cot_admin = JTable::getInstance('cot_admin', 'Cot_formsTable', array());

            $cot_admin->observer_name = $jinput->json->get('observer_name', '', 'STRING');
            $cot_admin->observer_tel = $jinput->json->get('observer_tel', '', 'STRING');
            $cot_admin->observer_email = $jinput->json->get('observer_email', '', 'STRING');
            $cot_admin->observation_datetime = $jinput->json->get('observation_datetime', '', 'STRING');
            $cot_admin->observation_location = $jinput->json->get('observation_location', '', 'STRING');
            $cot_admin->observation_localisation = $jinput->json->get('observation_localisation', '', 'STRING');
            $cot_admin->observation_region = $jinput->json->get('observation_region', '', 'STRING');
            $cot_admin->observation_country = $jinput->json->get('observation_country', '', 'STRING');
            $cot_admin->observation_country_code = $jinput->json->get('observation_country_code', '', 'STRING');
            $cot_admin->observation_latitude = $jinput->json->get('observation_latitude', '', 'STRING');
            $cot_admin->observation_longitude = $jinput->json->get('observation_longitude', '', 'STRING');
            $cot_admin->observation_number = $jinput->json->get('observation_number', '', 'STRING');
            $cot_admin->observation_culled = $jinput->json->get('observation_culled', '', 'STRING');
            $cot_admin->observation_state = $jinput->json->get('observation_state', '', 'STRING');
            $cot_admin->counting_method_timed_swim = $jinput->json->get('counting_method_timed_swim', '', 'STRING');
            $cot_admin->counting_method_distance_swim = $jinput->json->get('counting_method_distance_swim', '', 'STRING');
            $cot_admin->counting_method_other = $jinput->json->get('counting_method_other', '', 'STRING');
            $cot_admin->depth_range = $jinput->json->get('depth_range', '', 'STRING');
            $cot_admin->observation_method = $jinput->json->get('observation_method', '', 'STRING');
            $cot_admin->remarks = $jinput->json->get('remarks', '', 'STRING');
		

		// Check the data.
		if (!$cot_admin->check())
		{
			$obj->status = 0;
			$obj->code = 'ER003';
            $obj->message = $article->getError();
			return $obj;
		}

		// Store the data.
		if (!$cot_admin->store())
		{
			$obj->status = 0;
			$this->setError($cot_admin->getError());
			$obj->code = 'ER004';
            $obj->message = $article->getError();
			return $obj;
		}
		$obj->status = 1;
		$obj->code = 'OK';
        $obj->message = 'Message sent OK';
		return $obj;
	}
	
}
