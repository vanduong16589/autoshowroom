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

class PlgTZ_Portfolio_PlusMediaTypeQuote extends TZ_Portfolio_PlusPlugin
{
    protected $autoloadLanguage = true;
    protected $special          = true;

    public function onContentDisplayMediaType($context, &$article, $params, $page = 0, $layout = null){
        if(isset($article) && $article){
            if($media = $article -> media){
                if(isset($media -> quote)){
                    $this -> setVariable('quote', $media -> quote);
                }
            }
            $this -> setVariable('item', $article);
            return parent::onContentDisplayMediaType($context, $article, $params, $page, $layout);
        }
    }
}