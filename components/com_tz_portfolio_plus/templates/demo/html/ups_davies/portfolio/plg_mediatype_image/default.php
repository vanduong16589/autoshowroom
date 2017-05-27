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

					// Display button image
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
					
<!--					<a href="--><?php //echo $image_url;?><!--" class="tzpp_button font_montserrat"-->
<!--					   data-rel="prettyPhoto[pp_gal]"-->
<!--						title="--><?php //echo $item -> title;?><!--">-->
<!--						--><?php //echo JText::sprintf('TZ_PORTFOLIO_PLUS_TPL_DEMO_ZOOM'); ?>
<!--					</a>-->
					<?php if($params -> get('show_cat_readmore',1)):
						$link   = $item -> link;
						if($params -> get('ups_use_external_link',1) && $params -> get('ups_external_link')){
							$link   = $params -> get('ups_external_link');
						}?>
						<a class="font_montserrat TzPortfolioReadmore<?php if($params -> get('tz_use_lightbox', 1)){
							echo ' fancybox fancybox.iframe';}?>" href="<?php echo $link; ?>">
							 <?php echo JText::sprintf('COM_TZ_PORTFOLIO_PLUS_READ_MORE'); ?>
						</a>
					<?php endif;?>
                </div>
            </div>
        </div>
        <?php }?>


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
<?php endif;?>
