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

if (class_exists('JComponentRouterBase')) {
	class EcwidRouter extends JComponentRouterBase {
		public function parse(&$segments) {
			return EcwidParseRoute($segments);
		}

		public function build(&$query) {
			return EcwidBuildRoute($query);
		}
	}
}

function EcwidBuildRoute(&$query) {
	$segments = array();
	if(isset($query['view']))
	{
		unset($query['view']);
	}
	if(isset($query['id']))
	{
		$segments[] = $query['id'];
		unset($query['id']);
	};
	if (isset($query['ecwidPath'])) {
		$segments = array_merge($segments, explode('/', $query['ecwidPath']));
	}
	return $segments;
}

function EcwidParseRoute(&$segments) {
	$ecwidPath = '';
	if (is_array($segments) && !empty($segments)) {
		$ecwidPath = implode('/', $segments);
	}
	$segments = array();
	
	$result = array(
		'view' => 'ecwid'
	);

	if ($ecwidPath) {
		$result['ecwidPath'] = $ecwidPath;
	}

	return $result;
}
