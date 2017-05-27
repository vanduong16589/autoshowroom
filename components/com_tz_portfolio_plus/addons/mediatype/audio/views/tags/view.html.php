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
		$item 			= $this -> get('Item');

        if($item){
            if($media = $item -> media){
                if(isset($media -> audio)){
                    $audio  = clone($media -> audio);
                    if($size = $params -> get('mt_audio_thumbnail_size','o')){
                        if(isset($audio -> thumbnail) && !empty($audio -> thumbnail)) {
                            $image_url_ext      = JFile::getExt($audio->thumbnail);
                            $image_url          = str_replace('.' . $image_url_ext, '_' . $size . '.'
                                . $image_url_ext, $audio->thumbnail);
                            $audio -> thumbnail = JURI::root().$image_url;
                        }
                    }

                    if(isset($audio -> type) && $audio -> type == 'soundcloud'){
                        if(isset($audio -> code) && !empty($audio -> code)) {
                            $audioOption= '';
                            if($params -> get('mt_audio_show_soundcloud_artwork',1)){
                                $audioOption    .= '&amp;show_artwork=true';
                            }else{
                                $audioOption    .= '&amp;show_artwork=false';
                            }
                            if($params -> get('mt_audio_soundcloud_auto_play',0)){
                                $audioOption    .= '&amp;auto_play=true';
                            }else{
                                $audioOption    .= '&amp;auto_play=false';
                            }
                            if($params -> get('mt_audio_show_soundcloud_sharing',1)){
                                $audioOption    .= '&amp;sharing=true';
                            }else{
                                $audioOption    .= '&amp;sharing=false';
                            }
                            if($params -> get('mt_audio_show_soundcloud_buying',1)){
                                $audioOption    .= '&amp;buying=true';
                            }else{
                                $audioOption    .= '&amp;buying=false';
                            }
                            if($params -> get('mt_audio_show_soundcloud_download',1)){
                                $audioOption    .= '&amp;download=true';
                            }else{
                                $audioOption    .= '&amp;download=false';
                            }
                            if($params -> get('mt_audio_show_soundcloud_user',1)){
                                $audioOption    .= '&amp;show_user=true';
                            }else{
                                $audioOption    .= '&amp;show_user=false';
                            }
                            if($params -> get('mt_audio_show_soundcloud_playcount',1)){
                                $audioOption    .= '&amp;show_playcount=true';
                            }else{
                                $audioOption    .= '&amp;show_playcount=false';
                            }
                            if($params -> get('mt_audio_show_soundcloud_comments',1)){
                                $audioOption    .= '&amp;show_comments=true';
                            }else{
                                $audioOption    .= '&amp;show_comments=false';
                            }

                            if($color   = $params -> get('mt_audio_soundcloud_color','transparent')){
                                if($color != 'transparent'){
                                    $audioOption    .= '&amp;color='.str_replace('#','',$color);
                                }
                            }
                            if($themeColor   = $params -> get('mt_audio_soundcloud_theme_color','transparent')){
                                if($themeColor != 'transparent'){
                                    $audioOption    .= '&amp;theme_color='.$themeColor;
                                }
                            }
                            if($audioWidth   = $params -> get('mt_cat_audio_soundcloud_width','100%')){
                                if(!preg_match('/[0-9]+(\%|px)/i',$audioWidth)){
                                    $audioWidth .= 'px';
                                    $params -> set('mt_cat_audio_soundcloud_width',$audioWidth);
                                }
                            }
                            if($audioHeight   = $params -> get('mt_cat_audio_soundcloud_height')){
                                if(!preg_match('/[0-9]+(\%|px)/i',$audioHeight)){
                                    $audioHeight .= 'px';
                                    $params -> set('mt_cat_audio_soundcloud_height',$audioHeight);
                                }
                            }
                            $audio->url = 'https://w.soundcloud.com/player/?url=' . urlencode('https://api.soundcloud.com/tracks/'
                                    . $audio->code) . $audioOption;
                        }
                    }
                    $this -> audio  = $audio;
                }
            }
            $this -> item   = $item;
        }

        parent::display($tpl);
    }
}