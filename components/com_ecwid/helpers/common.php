<?php
/**
 * @author     Ecwid, Inc http://www.ecwid.com
 * @copyright  (C) 2009 - 2021 Ecwid, Inc.
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Contributors:
 * @author     Rick Blalock
 * @license    GNU/GPL
 * and
 * @author     RocketTheme http://www.rockettheme.com
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

/**
 * ecwid Common Helper
 */
class EcwidCommon  {

	static function getScriptURL()
	{
		$app = JFactory::getApplication();
		$eparams = $app->getParams();
		if ($eparams->get('storeID', null) == null) {
			$eparams = JComponentHelper::getParams('com_ecwid');
		}

		$ecwid_script = "app.ecwid.com/script.js";
		$protocol = 'https://';

		$script_params = array(
			$eparams->get('storeID', 1003),
			'data_platform=joomla'
		);

		if (version_compare(JVERSION, '4.0.0', '>=')) {
			$script_params[] = 'data_version=4';
		}

		if ($eparams->get('useSeoLinks')) {
			$script_params[] = 'data_clean_urls=1';
		}

		$script_params = implode('&', $script_params);

		$script_url = $protocol . $ecwid_script . '?' . $script_params;

		return $script_url;
	}


	// Returns ecwid_ProductBrowserURL javascript code that provides modules with a product browser url to link to
	static function getProductBrowserJS() {
		global $ecwid_itemid, $Itemid, $option;

		if ($option == 'com_ecwid') {
			$ecwid_itemid = $Itemid;
		} elseif (!isset($ecwid_itemid)) {
			$db = JFactory::getDBO();
			$queryitemid = "SELECT id FROM #__menu WHERE type='component' AND link LIKE '%com_ecwid%view=ecwid%' AND published='1' ORDER BY id ASC LIMIT 1";
			$db->setQuery($queryitemid);
			$ecwid_itemid = $db->loadResult();
		}
		$url = 'index.php?option=com_ecwid';
		if ($ecwid_itemid) {
			$url .= '&Itemid=' . $ecwid_itemid;
		}

		$url = EcwidCommon::getProductBrowserURL();

		$code = '<script type="text/javascript">';
		$code .= ' var ecwid_ProductBrowserURL = "' . $url . '"';
		$code .= '</script>';

		return $code;
	}

    // Returns ecwid_ProductBrowserURL javascript code that provides modules with a product browser url to link to
    static function getProductBrowserURL() {
        global $ecwid_itemid, $Itemid, $option;

        if ($option == 'com_ecwid') {
            $ecwid_itemid = $Itemid;
        } elseif (!isset($ecwid_itemid)) {
            $db = JFactory::getDBO();
            $queryitemid = "SELECT id FROM #__menu WHERE type='component' AND link LIKE '%com_ecwid%view=ecwid%' AND published='1' ORDER BY id ASC LIMIT 1";
            $db->setQuery($queryitemid);
            $ecwid_itemid = $db->loadResult();
        }
        $url = 'index.php?option=com_ecwid';
        if ($ecwid_itemid) {
            $url .= '&Itemid=' . $ecwid_itemid;
        }

        $url = JRoute::_($url, true);

        return $url;
    }

    static function isPaidAccount($storeId = null)
    {
        include_once "ecwid_product_api.php";

        if (is_null($storeId)) {
            $eparams = JComponentHelper::getParams( 'com_ecwid' );

            $storeId = $eparams->get('storeID');
        }
        $api = new EcwidProductApi($storeId);

        return $api->is_api_enabled() && is_numeric($storeId) && $storeId != 1003;
    }


    public static function setParam($param, $value) {

        $params = new JRegistry();
        $table  = JTable::getInstance('extension');
        $result = $table->find(array('element' => 'com_ecwid'));
        $table->load($result);
        $params->loadString($table->params);

        $params->set($param, $value);

        $table  = JTable::getInstance('extension');
        $result = $table->find(array('element' => 'com_ecwid'));
        $table->load($result);

        $table->params = $params->__toString();

        $table->store();
    }

	public static function fetchComponentVersion() {
		$params = new JRegistry();
		$table  = JTable::getInstance('extension');
		$result = $table->find(array('element' => 'com_ecwid'));
		$table->load($result);
		$params->loadString($table->manifest_cache);

		return $params->get('version');
	}


	public static function getAdminSubmenuItems()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select(
			array(
				$db->quoteName('id'),
				$db->quoteName('title')
			)
		)
		->from($db->quoteName('#__menu'))
		->where(
			array(
				$db->quoteName('alias') . ' = ' . $db->quote('com-ecwid-advanced-settings') 
				. ' OR ' .
				$db->quoteName('alias') . ' = ' . $db->quote('com-ecwid-appearance-settings'),
			)
		);

		$db->setQuery($query);

		return $db->loadObjectList();
	}
	
	public static function toggleAdminSubmenuItems( $menu_show = 1 )
	{
		$items = self::getAdminSubMenuItems();

		if( !$items ) {
			return;
		}

		$db = JFactory::getDbo();

		$params = json_encode( array("menu_show" => $menu_show) );

		foreach ($items as $item)
		{
			$itemId = $item->id;

			$query = $db->getQuery(true)
				->update($db->quoteName('#__menu'))
				->set($db->quoteName('params') . ' = ' . $db->quote($params))
				->where($db->quoteName('id') . ' = ' . $db->quote($itemId));

			try
			{
				$db->setQuery($query)->execute();
			}
			catch (\RuntimeException $e)
			{
				$this->setMessage($e->getMessage(), 'warning');

				return;
			}
		}
	}
}
?>
