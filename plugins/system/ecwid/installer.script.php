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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

if (!class_exists('plgsystemecwidInstallerScript')) {

	/**
	 *
	 */
	class plgsystemecwidInstallerScript
	{
		/**
		 * @param $type
		 * @param $parent
		 */
		public function postflight($type, $parent)
		{
            if (strtolower($type) === 'install') 
		    {
		        $db = JFactory::getDbo();
		        $query = $db->getQuery(true);

		        $fields = array(
		            $db->quoteName('enabled') . ' = 1'
		        );

		        $conditions = array(
		            $db->quoteName('element') . ' = ' . $db->quote('ecwid'), 
		            $db->quoteName('type') . ' = ' . $db->quote('plugin')
		        );

		        $query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);

		        $db->setQuery($query);   
		        $db->execute();     
		    }
		}
	}
}
