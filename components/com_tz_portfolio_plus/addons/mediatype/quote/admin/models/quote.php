<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2015 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

class PlgTZ_Portfolio_PlusMediaTypeModelQuote extends TZ_Portfolio_PlusPluginModelAdmin
{
    // This function to upload and save data with data saved in com
    public function save($data){

        // Get data from form
        $quote_data     = JRequest::getVar('jform',array());
        $quote_data     = $quote_data['media'][$this -> getName()];

        $this -> __save($data,$quote_data);

    }
}