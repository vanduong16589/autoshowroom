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
<?php
if(!isset($item -> mediatypes) || (isset($item -> mediatypes) && !in_array($item -> type,$item -> mediatypes))){
    ?>
    <div class="tzpp_absolute">
        <?php if($params -> get('show_cat_readmore',1)):
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
            <a class="tzpp_button tz_plus TzPortfolioReadmore" href="<?php echo $image_url;?>" data-rel="prettyPhoto[pp_gal]"
               title="<?php echo $item -> title; ?>">
                <span class="bar-horizontal"></span>
                <span class="bar-vertical"></span>
            </a>
        <?php endif;?>
    </div>
<?php }?>
<?php endif;?>
