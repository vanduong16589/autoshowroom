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

$item   = $this -> item;
$audio  = $this -> audio;
$params = $this -> params;

if($item   = $this -> item) :
    if (isset($this->audio) && $audio = $this->audio) :
        if($audio -> type == 'embed'){
            echo $audio -> embed_code;
        }else{
        ?>
            <iframe width="<?php echo $params -> get('mt_audio_soundcloud_width');?>"
                    height="<?php echo $params -> get('mt_audio_soundcloud_height');?>"
                    src="<?php echo $audio -> url;?>"
                    frameborder="0" allowfullscreen
                    itemprop="embedUrl">
            </iframe>
        <?php }?>
<?php endif;
endif;