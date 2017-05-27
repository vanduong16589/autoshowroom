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
$image  = $this -> image;
$params = $this -> params;

if($item && $image && isset($image -> url) && !empty($image -> url)):
    $class  = null;
    if($params -> get('tz_use_lightbox',0)){
        $class=' class = "fancybox fancybox.iframe"';
    }
?>



<div class="tz_portfolio_plus_image">
    <a<?php echo $class;?> href="<?php echo $item -> link;?>">
        <img src="<?php echo $image -> url;?>"
             alt="<?php echo isset($image -> caption)?$image -> caption:$item -> title;?>"
             title="<?php echo isset($image -> caption)?$image -> caption:$item -> title;?>"
             itemprop="thumbnailUrl"/>
        <?php if($params -> get('mt_show_cat_image_hover',1)):?>
            <?php if(isset($image -> url_hover)):?>
                <img class="tz_image_hover"
                     src="<?php echo $image -> url_hover;?>"
                     alt="<?php echo ($image -> caption)?($image -> caption):$item -> title;?>"
                     title="<?php echo ($image -> caption)?($image -> caption):$item -> title;?>"/>
            <?php endif;?>
        <?php endif;?>
    </a>
</div>
    <div class="TzButtonAction">
        <?php
        $image_url  = $image -> url;
        if ($size = $params->get('mt_image_size', 'o')) {
            if (isset($image->temp) && !empty($image->temp)) {
                $image_url_ext = JFile::getExt($image->temp);
                $image_url = str_replace('.' . $image_url_ext, '_' . $size . '.'
                    . $image_url_ext, $image->temp);
                $image_url = JURI::root() . $image_url;
            }
        }
        ?>
        <a href="<?php echo $image_url;?>" class="tz_button_action white left"
           data-rel="prettyPhoto[tzpp_image]"
           title="<?php echo $item -> title;?>">
            <i class="tzpp_icon tzpp_icon-image"></i>
        </a>
        <a class="tzpp_button tz_button_action black right TzPortfolioReadmore<?php if($params -> get('tz_use_lightbox', 1)){
            echo ' fancybox fancybox.iframe';}?>" href="<?php echo $item ->link; ?>"  itemprop="url">
            <i class="tzpp_icon tzpp_icon-link tzpp_icon-rotate-90"></i>
        </a>

    </div>
<?php endif;?>
