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

class PlgTZ_Portfolio_PlusMediaTypeQuoteViewPortfolio extends JViewLegacy
{
    protected $item     = null;
    protected $params   = null;
    protected $quote    = null;
    protected $head     = false;

    public function display($tpl = null){
        $state          = $this -> get('State');
        $params         = $state -> get('params');
        $this -> params = $params;
		$item 			= $this -> get('Item');
		
        if($item){
            if($media = $item -> media){
                if(isset($media -> quote)){
                    $this -> quote  = $media -> quote;
                }
            }
            $this -> item   = $item;
        }

        if(!$this -> head) {
            $doc = JFactory::getDocument();
            $doc->addStyleSheet(TZ_Portfolio_PlusUri::base() . '/addons/mediatype/quote/css/quote.css');
            $this -> head   = true;
        }

        parent::display($tpl);
    }
}