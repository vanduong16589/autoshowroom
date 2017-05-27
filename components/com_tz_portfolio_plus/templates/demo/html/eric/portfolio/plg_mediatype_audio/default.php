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
if($params -> get('mt_show_cat_audio',1)):
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
        <?php
        if(!isset($item -> mediatypes) || (isset($item -> mediatypes) && !in_array($item -> type,$item -> mediatypes))){
            ?>
            <?php if($params -> get('show_cat_readmore',1) && $audio -> type != 'embed'){?>
                <div class="tzpp_absolute">
                    <div class="tzpp_table">
                        <div class="tzpp_table-cell">
                            <a href="<?php echo $audio -> url.'?iframe=true';?>"
                               class="tzpp_button" data-rel="prettyPhoto[tzpp_audio]"
                               title="<?php echo $item -> title;?>">
                                <i class="tzpp_icon tzpp_icon-headphones"></i></a>
                            <a class="tzpp_button TzPortfolioReadmore<?php if($params -> get('tz_use_lightbox', 1)){
                                echo ' fancybox fancybox.iframe';}?>" href="<?php echo $item ->link; ?>">
                                <i class="tzpp_icon tzpp_icon-link tzpp_icon-rotate-90"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php }?>
        <?php }?>
    <?php }else{
        if($audio -> type == 'embed'){
            echo $audio -> embed_code;
        }else{
    ?>
    <iframe width="<?php echo $params -> get('mt_audio_soundcloud_width','100%');?>"
            height="<?php echo $params -> get('mt_audio_soundcloud_height');?>"
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