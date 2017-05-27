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
if($params -> get('mt_show_video',1)):
    if($item   = $this -> item) {
        if (isset($this->video) && $video = $this->video) {
?>
<div class="tz_portfolio_plus_video">
    <?php if($params -> get('mt_video_switcher','thumbnail') == 'thumbnail'){
        $class  = null;
        if($params -> get('tz_use_lightbox',0)){
            $class=' class = "fancybox fancybox.iframe"';
        }
    ?>
    <a<?php echo $class; ?> href="<?php echo $this -> item -> link; ?>">
        <img src="<?php echo $video -> thumbnail; ?>"
             title="<?php echo ($video -> title) ? ($video -> title) : ($this->item->title); ?>"
             alt="<?php echo ($video -> title) ? ($video -> title) : ($this->item->title); ?>"
             itemprop="thumbnailUrl"/>
    </a>

    <?php
    if(!isset($item -> mediatypes) || (isset($item -> mediatypes) && !in_array($item -> type,$item -> mediatypes))){
        ?>
        <div class="tzpp_absolute">
            <?php if($params -> get('show_cat_readmore',1)):
            if($video -> type != 'embed'){
                $video_url  = null;
                if($video -> type == 'vimeo'){
                    $video_url  = 'https://vimeo.com/'.$video -> code;
                }elseif($video -> type == 'youtube'){
                    $video_url  = 'https://www.youtube.com/watch?v='.$video -> code;
                }
                if($video_url){
                ?>
                <a class="tzpp_button tz_plus TzPortfolioReadmore" href="<?php echo $video_url;?>" data-rel="prettyPhoto[pp_gal]"
                   title="<?php echo $item -> title; ?>">
                    <span class="bar-horizontal"></span>
                    <span class="bar-vertical"></span>
                </a>
            <?php }
            }
            endif;?>
        </div>
    <?php }?>

    <?php }else{
        if($video -> type == 'embed'){
            echo $video -> embed_code;
        }else{
    ?>

        <iframe src="<?php echo $video -> url;?>"
                width="<?php echo $params -> get('mt_cat_video_width');?>"
                height="<?php echo $params -> get('mt_cat_video_height');?>"
                frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen itemprop="embedUrl">
        </iframe>
    <?php }
    }
    ?>
</div>
<?php
        }
    }
endif;?>