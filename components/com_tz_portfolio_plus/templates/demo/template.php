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

$params     = $this -> params;
$doc        = JFactory::getDocument();
$doc->addScript(TZ_Portfolio_PlusUri::base(true).'/templates/'.$this -> template.'/js/jquery.prettyPhoto.js');
$doc->addScript(TZ_Portfolio_PlusUri::base(true).'/templates/'.$this -> template.'/js/custom.js');
$doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true).'/templates/'.$this -> template.'/css/tzportfolioplus_font.css');
$doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true).'/templates/'.$this -> template.'/css/prettyPhoto.css');

JHtml::addIncludePath(COM_TZ_PORTFOLIO_PLUS_TEMPLATE_PATH.'/'.$this -> template.'/libraries/html');

if($layout = $params -> get('layout')){
    if(file_exists(COM_TZ_PORTFOLIO_PLUS_TEMPLATE_PATH.DIRECTORY_SEPARATOR.$this -> template
        .DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$layout.'.css')){
        $doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true).'/templates/'.$this -> template.'/css/themes/'.$layout.'.css');
    }
}