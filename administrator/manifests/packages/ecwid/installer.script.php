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

if (!class_exists('pkg_ecwidInstallerScript')) {

	/**
	 *
	 */
	class pkg_ecwidInstallerScript
	{
		/**
		 * @param $type
		 * @param $parent
		 */
		public function postflight($type, $parent)
		{
            if (strtolower($type) === 'install') 
		    {
            	$parent->getParent()->setRedirectURL('index.php?option=com_ecwid');
       		}
		}
	}
}
