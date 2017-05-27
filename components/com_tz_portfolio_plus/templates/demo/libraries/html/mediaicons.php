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
defined('JPATH_PLATFORM') or die;

abstract class JHtmlMediaIcons{
    static $mediatype_icons    = array('image' => 'tzpp_icon tzpp_icon-image',
            'image_gallery' => 'tzpp_icon tzpp_icon-images', 'video' => 'tzpp_icon tzpp_icon-film'
        , 'audio' => 'tzpp_icon tzpp_icon-volume-medium');

    public static function Icon($mediatype){
        if($mediatype){
            if(isset(self::$mediatype_icons[$mediatype])){
                return self::$mediatype_icons[$mediatype];
            }
        }
        return false;
    }
}