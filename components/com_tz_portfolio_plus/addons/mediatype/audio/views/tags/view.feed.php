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

// No direct access.
defined('_JEXEC') or die;

class PlgTZ_Portfolio_PlusMediaTypeAudioViewTags extends JViewLegacy{
    protected $item     = null;
    protected $params   = null;
    protected $audio     = null;

    public function display($tpl = null){
        $state          = $this -> get('State');
        $params         = $state -> get('params');
        $this -> params = $params;
        $item           = &$this -> item;

        if(!$item){
            $item = $this -> get('Item');
        }

        if($item){
            if($media = $item -> media){
                if(isset($media -> audio)){
                    $audio  = clone($media -> audio);
                    if($params -> get('mt_audio_show_feed_image',1)){
                        $title = $this->escape($item->title);
                        $title = html_entity_decode($title, ENT_COMPAT, 'UTF-8');

                        $link = JRoute::_(TZ_Portfolio_PlusHelperRoute::getArticleRoute($item -> slug, $item -> catid, true, -1));

                        if($size = $params -> get('mt_audio_feed_size','o')){
                            if(isset($audio -> thumbnail) && !empty($audio -> thumbnail)) {
                                $image_url_ext      = JFile::getExt($audio->thumbnail);
                                $image_url          = str_replace('.' . $image_url_ext, '_' . $size . '.'
                                    . $image_url_ext, $audio->thumbnail);
                                $audio -> thumbnail = JURI::root().$image_url;

                                echo '<a href="'.$link.'"><img src="'.$audio -> thumbnail.'" alt="'.$title.'"/></a>';
                            }
                        }
                    }

                    if($code = $audio -> code){
                        if($audio -> type != 'embed'){
                            $item -> description    = '<p>'.htmlspecialchars('{'.$audio -> type.'}'.$audio -> code.'|'
                                    .$params -> get('mt_audio_soundcloud_width','100%')
                                    .'|'.$params -> get('mt_audio_soundcloud_height','auto')
                                    .'{/'.$audio -> type.'}').'</p>'.$item -> description;
                        }
                    }
                }
            }
        }
    }
}