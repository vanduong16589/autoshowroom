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

$params = $this->params;
if($params -> get('mt_show_audio',1)):
    if($item   = $this -> item) {
        if (isset($this->audio) && $audio = $this->audio) {
?>
<div class="tz_audio" itemprop="audio" itemscope itemtype="http://schema.org/AudioObject">
    <?php if($params -> get('mt_audio_switcher','thumbnail') == 'thumbnail'){
        $class  = null;
        if($params -> get('tz_use_lightbox',0)){
            $class=' class = "fancybox fancybox.iframe"';
        }
    ?>
        <a<?php echo $class; ?> href="<?php echo $this -> item -> link; ?>">
            <img src="<?php echo $audio -> thumbnail; ?>"
                 title="<?php echo ($audio -> caption) ? ($audio -> caption) : ($this->item->title); ?>"
                 alt="<?php echo ($audio -> caption) ? ($audio -> caption) : ($this->item->title); ?>"
                 itemprop="thumbnailUrl"/>
        </a>
    <?php }else{
        if($audio -> type == 'embed'){
            echo $audio -> embed_code;
        }else{
    ?>
    <iframe width="<?php echo $params -> get('mt_cat_audio_soundcloud_width','100%');?>"
            height="<?php echo $params -> get('mt_cat_audio_soundcloud_height');?>"
            src="<?php echo $audio -> url;?>"
            frameborder="0" allowfullscreen
            itemprop="embedUrl">
    </iframe>
    <?php }
    }
    ?>
</div>
<?php }
    }
endif;
?>