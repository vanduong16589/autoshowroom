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

// no direct access
defined('_JEXEC') or die('Restricted access');

if($item = $this -> item) :
    $params = $this -> item -> params;
    if($item->event->onContentDisplayMediaType && !empty($item->event->onContentDisplayMediaType)){
        $mediatype_icons    = array('image' => 'tzpp_icon tzpp_icon-image',
            'image_gallery' => 'tzpp_icon tzpp_icon-images', 'video' => 'tzpp_icon tzpp_icon-film'
        , 'audio' => 'tzpp_icon tzpp_icon-volume-medium');
?>
<div class="TzArticleMedia">

    <?php
    if(!isset($item -> mediatypes) || (isset($item -> mediatypes) && !in_array($item -> type,$item -> mediatypes))){
    ?>
	   
        <?php if($params -> get('show_cat_readmore',1) || ($params->get('show_cat_intro',1) AND !empty($item -> introtext))){?>
        <div class="tzpp_absolute">
            <div class="tzpp_table">
                <div class="tzpp_table-cell">
					<?php  if ($params->get('show_cat_intro',1) AND !empty($item -> introtext)) :?>
						<div class="TzPortfolioIntrotext font_montserrat" itemprop="description">
							<?php echo $item -> introtext;?>
						</div>
					<?php endif; ?>
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
    <?php }?>

    <?php echo $item->event->onContentDisplayMediaType; ?>
</div>
<?php }
endif;