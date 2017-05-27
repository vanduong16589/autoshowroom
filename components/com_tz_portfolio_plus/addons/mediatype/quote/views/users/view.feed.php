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

class PlgTZ_Portfolio_PlusMediaTypeQuoteViewUsers extends JViewLegacy
{
    protected $item     = null;
    protected $params   = null;
    protected $quote    = null;

    public function display($tpl = null){
        $state          = $this -> get('State');
        $params         = $state -> get('params');
        $this -> params = $params;
        $item           = $this -> item;

        if(!$item){
            $item = $this -> get('Item');
        }

        if($item){
            if($media = $item -> media){
                if(isset($media -> quote)){
                    $quote  = $media -> quote;

                    // Set feed introtext by quote's text
                    $item -> description          = '<em>'.$quote -> text.'</em>';

                    // Set feed author by quote's author
                    $item -> created_by_alias   = null;
                    $item -> author             = $quote -> author;
                }
            }
        }
    }
}