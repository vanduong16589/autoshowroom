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

        <?php if($params -> get('show_cat_readmore',1) || ($params->get('show_cat_intro',1) AND !empty($item -> introtext)) || $params->get('show_cat_tags', 0)){?>
            <div class="tzpp_absolute">
                <div class="tzpp_table">
                    <div class="tzpp_table-cell">

                        <?php  if ($params->get('show_cat_intro',1) AND !empty($item -> introtext)) :?>
                            <div class="TzPortfolioIntrotext font_montserrat" itemprop="description">
                                <?php echo $item -> introtext;?>
                            </div>
                        <?php endif; ?>

                        <?php
                        if ($params->get('show_cat_tags', 0)) :
                            $document = JFactory::getDocument();
                            $viewType = $document->getType();
                            $controller = TZ_Portfolio_PlusControllerLegacy::getInstance('TZ_Portfolio_Plus');
                            $view       = $controller -> getView('Portfolio',$viewType);
                            $view -> assign('params',$params);
                            $view -> assign('item',$item);

                            echo $view -> loadTemplate('tags');
                        endif;
                        ?>

                        <?php if($audio -> type != 'embed'){ ?>
                        <a href="<?php echo $audio->url . '?iframe=true';?>" class="tzpp_button font_montserrat"
                           data-rel="prettyPhoto[pp_gal]"
                           title="<?php echo $item -> title;?>">
                            <?php echo JText::sprintf('TZ_PORTFOLIO_PLUS_TPL_DEMO_ZOOM'); ?>
                        </a>
                        <?php }?>
                        <?php if($params -> get('show_cat_readmore',1)): ?>
                            <a class="font_montserrat TzPortfolioReadmore<?php if($params -> get('tz_use_lightbox', 1)){
                                echo ' fancybox fancybox.iframe';}?>" href="<?php echo $item ->link; ?>">
                                <?php echo JText::sprintf('COM_TZ_PORTFOLIO_PLUS_READ_MORE'); ?>
                            </a>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        <?php }?>

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