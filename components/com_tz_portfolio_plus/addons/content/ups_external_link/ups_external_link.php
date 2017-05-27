<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Extension

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# Copyright: Copyright (C) 2015 templaza.com. All Rights Reserved.

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

JLoader::import('route',JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR
    .'com_tz_portfolio_plus'.DIRECTORY_SEPARATOR.'helpers');
JLoader::import('framework',JPATH_ADMINISTRATOR.'/components/com_tz_portfolio_plus/includes');

/**
 * Pagenavigation plugin class.
 */
class PlgTZ_Portfolio_PlusContentUPS_External_Link extends TZ_Portfolio_PlusPlugin
{
    protected $autoloadLanguage = true;
}
?>