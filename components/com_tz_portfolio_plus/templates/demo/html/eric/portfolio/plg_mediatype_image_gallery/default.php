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
if($params -> get('mt_show_image_gallery',1)):
    if($item   = $this -> item) {
        if (isset($this->image_gallery) && $slider = $this->image_gallery) {
            $class  = null;
            if($params -> get('tz_use_lightbox',0)){
                $class=' class = "fancybox fancybox.iframe"';
            }
?>
<div class="tz_portfolio_plus_image_gallery">
    <?php if($params -> get('mt_img_gallery_switcher','image') == 'image'){?>
    <a<?php echo $class; ?> href="<?php echo $this -> item -> link; ?>">
        <img src="<?php echo $slider -> url[0]; ?>"
             alt="<?php echo ($slider -> caption[0]) ? ($slider -> caption[0]) : ($this->item->title); ?>"
             title="<?php echo ($slider -> caption[0]) ? ($slider -> caption[0]) : ($this->item->title); ?>"
             itemprop="thumbnailUrl"/>
    </a>
        <?php
        if(!isset($item -> mediatypes) || (isset($item -> mediatypes) && !in_array($item -> type,$item -> mediatypes))){
            ?>
            <?php if($params -> get('show_cat_readmore',1)){
                $image_url  = $slider -> url[0];
                if ($size = $params->get('mt_img_gallery_size', 'o')) {
                    if (isset($slider->temp[0]) && !empty($slider->temp[0])) {
                        $image_url_ext = JFile::getExt($slider->temp[0]);
                        $image_url = str_replace('.' . $image_url_ext, '_' . $size . '.'
                            . $image_url_ext, $slider->temp[0]);
                        $image_url = JURI::root() . $image_url;
                    }
                }
            ?>
                <div class="tzpp_absolute">
                    <div class="tzpp_table">
                        <div class="tzpp_table-cell">
                            <a href="<?php echo $image_url;?>" class="tzpp_button"
                               data-rel="prettyPhoto[tzpp_image]"
                               title="<?php echo $item -> title;?>">
                                    <i class="tzpp_icon tzpp_icon-images"></i></a>
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
        $dirNav         = 'false';
        $controlNav     = 'false';
        $pausePlay      = 'false';
        $pauseOnAction  = 'false';
        $pauseOnHover   = 'false';
        $useCSS         = 'false';
        $slideshow      = 'false';
        $animationLoop  = 'false';
        $smoothHeight   = 'false';
        $randomize      = 'false';
        $animation      = '\'fade\'';

        if($params -> get('mt_img_gallery_flex_show_arrows',1)) {
            $dirNav     = 'true';
        }
        if($params -> get('mt_img_gallery_flex_show_controlNav',1)) {
            $controlNav = 'true';
            if ($params->get('mt_img_gallery_flex_controlnav_type', 'none') == 'thumbnails' )
                $controlNav = $params->get('mt_img_gallery_flex_controlnav_type', 'none');
        }
        if($params -> get('mt_img_gallery_flex_pausePlay',1)) {
            $pausePlay = 'true';
        }
        if($params -> get('mt_img_gallery_flex_pauseOnAction',1)){
            $pauseOnAction   = 'true';
        }
        if($params -> get('mt_img_gallery_flex_pauseOnHover',1)){
            $pauseOnHover   = 'true';
        }
        if($params -> get('mt_img_gallery_flex_useCSS',1)){
            $useCSS   = 'true';
        }
        if($params -> get('mt_img_gallery_flex_animation')) {
            $animation = '\'' . $params->get('mt_img_gallery_flex_animation') . '\'';
        }
        if($params -> get('mt_img_gallery_flex_slideshow',1)){
            $slideshow  = 'true';
        }
        if($params -> get('mt_img_gallery_flex_animLoop',1)){
            $animationLoop  = 'true';
        }
        if($params -> get('mt_img_gallery_flex_smoothHeight',1)){
            $smoothHeight   = 'true';
        }
        if($params -> get('mt_img_gallery_flex_randomize',0)){
            $randomize  = 'true';
        }
//        ,
//        start: function(){
//            jQuery(".flexslider").css("width","'.$params -> get('tz_image_gallery_'.$name).'px")
//                    }
        $doc    = JFactory::getDocument();
        $doc -> addScriptDeclaration('
            jQuery(document).ready(function(){
                jQuery(".tz_portfolio_plus_image_gallery .flexslider").flexslider({
                    animation: '.$animation.',
                    slideDirection: "'.$params -> get('mt_img_gallery_flex_direction').'",
                    slideshow: '.$slideshow.',
                    slideshowSpeed: '.$params -> get('mt_img_gallery_flex_animSpeed').',
                    animationDuration: '.$params -> get('mt_img_gallery_flex_anim_duration').',
                    directionNav: '.$dirNav.',
                    controlNav: '.(($controlNav=='thumbnails')?'"'.$controlNav.'"':$controlNav).',
                    prevText: "'.JText::_('JPREVIOUS').'",
                    nextText: "'.JText::_('JNEXT').'",
                    pausePlay: '.$pausePlay.',
                    pauseText: "'.JText::_('PLG_MEDIATYPE_IMAGE_GALLERY_PAUSE').'",
                    playText: "'.JText::_('PLG_MEDIATYPE_IMAGE_GALLERY_PLAY').'",
                    pauseOnAction: '.$pauseOnAction.',
                    pauseOnHover: '.$pauseOnHover.',
                    useCSS: '.$useCSS.',
                    startAt: '.$params -> get('mt_img_gallery_flex_startAt',0).',
                    animationLoop: '.$animationLoop.',
                    smoothHeight: '.$smoothHeight.',
                    randomize: '.$randomize.',
                    itemWidth:'.$params -> get('mt_img_gallery_flex_itemWidth',0).',
                    itemMargin:'.$params -> get('mt_img_gallery_flex_itemMargin',0).',
                    minItems:'.$params -> get('mt_img_gallery_flex_minItems',0).',
                    maxItems:'.$params -> get('mt_img_gallery_flex_maxItems',0).'
                });
            });
        ');

    ?>
    <div class="flexslider">
        <ul class="slides">
            <?php foreach($slider -> url as $i => $url):?>
                <li<?php echo ($controlNav=='thumbnails')?' data-thumb="'.$slider -> thumb_url[$i].'"':''?>>
                    <img src="<?php echo $url;?>"
                         alt="<?php echo ($slider -> caption[$i])?($slider -> caption[$i]):($this -> item -> title);?>"
                        <?php if(!empty($slider -> caption[$i])):?>
                            title="<?php echo $slider -> caption[$i];?>"
                        <?php endif; ?>
                        />

                    <?php
                    if($slider -> caption[$i]):
                        ?>
                        <p class="flex-caption"><?php echo $slider -> caption[$i];?></p>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php }?>
</div>
<?php
        }
    }
endif;?>