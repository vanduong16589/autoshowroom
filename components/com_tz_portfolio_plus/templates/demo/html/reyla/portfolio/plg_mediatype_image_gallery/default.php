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
        if(!isset($item -> mediatypes) || (isset($item -> mediatypes) && !in_array($item -> type,$item -> mediatypes))):
        // Start Description and some info
        ?>
        <div class="TzPortfolioDescription">
            <div class="tzpp_table">
                <div class="tzpp_table-cell">

                    <div class="description-inner">
                        <?php
                        // Begin Icon print, Email or Edit
                        if ($params->get('show_cat_print_icon', 0) || $params->get('show_cat_email_icon', 0)
                            || $params -> get('access-edit')) : ?>
                            <div class="TzIcon">
                                <div class="btn-group dropdown pull-right" role="presentation">
                                    <a class="btn btn-default btn-sm dropdown-toggle"
                                       data-target="#" data-toggle="dropdown" href="javascript: void(0);">
                                        <i class="icon-cog"></i> <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php if ($params->get('show_cat_print_icon', 0)) : ?>
                                            <li class="print-icon"> <?php echo JHtml::_('icon.print_popup', $item, $params); ?> </li>
                                        <?php endif; ?>
                                        <?php if ($params->get('show_cat_email_icon', 0)) : ?>
                                            <li class="email-icon"> <?php echo JHtml::_('icon.email', $item, $params); ?> </li>
                                        <?php endif; ?>

                                        <?php if ($params -> get('access-edit')) : ?>
                                            <li class="edit-icon"> <?php echo JHtml::_('icon.edit', $item, $params); ?> </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endif;
                        // End Icon print, Email or Edit
                        ?>

                        <?php if($params -> get('show_cat_title',1)): ?>
                            <h3 class="TzPortfolioTitle name" itemprop="name">
                                <?php if($params->get('cat_link_titles',1)) : ?>
                                    <a<?php if($params -> get('tz_use_lightbox', 1)){echo ' class="fancybox fancybox.iframe"';}?>
                                        href="<?php echo $item ->link; ?>"  itemprop="url">
                                        <?php echo $this->escape($item -> title); ?>
                                    </a>
                                <?php else : ?>
                                    <?php echo $this->escape($item -> title); ?>
                                <?php endif; ?>
                            </h3>
                        <?php endif;?>

                        <?php
                        if(!$params -> get('show_cat_intro',1)) {
                            //Call event onContentAfterTitle on plugin
                            echo $item->event->afterDisplayTitle;
                        }
                        ?>

                        <?php
                        //Show vote
                        echo $item -> event -> contentDisplayVote;
                        ?>

                        <?php
                        //Call event onContentBeforeDisplay on plugin
                        echo $item -> event -> beforeDisplayContent;
                        ?>

                        <?php  if ($params->get('show_cat_intro',1) AND !empty($item -> introtext)) :?>
                            <div class="TzPortfolioIntrotext" itemprop="description">
                                <?php echo $item -> introtext;?>
                            </div>
                        <?php endif; ?>

                        <?php
                        //-- Start display some information --//
                        if ($params->get('show_cat_author',0) or $params->get('show_cat_category',0)
                            or $params->get('show_cat_create_date',0) or $params->get('show_cat_modify_date',0)
                            or $params->get('show_cat_publish_date',0) or $params->get('show_cat_parent_category',0)
                            or $params->get('show_cat_hits',0) or $params->get('show_tags',0)
                            or !empty($item -> event -> beforeDisplayAdditionInfo)
                            or !empty($item -> event -> afterDisplayAdditionInfo)) :
                            ?>
                            <div class="TzArticle-info">

                                <?php echo $item -> event -> beforeDisplayAdditionInfo;?>

                                <?php if ($params->get('show_cat_category',0)) : ?>
                                    <div class="TZcategory-name">
                                        <?php $title = $this->escape($item->category_title);
                                        $url = '<a href="' . $item -> category_link
                                            . '" itemprop="genre">' . $title . '</a>';
                                        $lang_text  = 'COM_TZ_PORTFOLIO_PLUS_CATEGORY';
                                        ?>

                                        <?php if(isset($item -> second_categories) && $item -> second_categories
                                            && count($item -> second_categories)){
                                            $lang_text  = 'COM_TZ_PORTFOLIO_PLUS_CATEGORIES';
                                            foreach($item -> second_categories as $j => $scategory){
                                                if($j <= count($item -> second_categories)) {
                                                    $title  .= ', ';
                                                    $url    .= ', ';
                                                }
                                                $url    .= '<a href="' . $scategory -> link
                                                    . '" itemprop="genre">' . $scategory -> title . '</a>';
                                                $title  .= $this->escape($scategory -> title);
                                            }
                                        }?>

                                        <?php if ($params->get('cat_link_category',1)) : ?>
                                            <?php echo JText::sprintf($lang_text, $url); ?>
                                        <?php else : ?>
                                            <?php echo JText::sprintf($lang_text, '<span itemprop="genre">' . $title . '</span>'); ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($params->get('show_cat_parent_category', 0) && $item->parent_id != 1) : ?>
                                    <div class="TzParentCategoryName">
                                        <?php $title = $this->escape($item->parent_title);
                                        $url = '<a href="' . JRoute::_(TZ_Portfolio_PlusHelperRoute::getCategoryRoute($item->parent_id)) . '" itemprop="genre">' . $title . '</a>'; ?>
                                        <?php if ($params->get('cat_link_parent_category', 1)) : ?>
                                            <?php echo JText::sprintf('COM_TZ_PORTFOLIO_PLUS_PARENT', $url); ?>
                                        <?php else : ?>
                                            <?php echo JText::sprintf('COM_TZ_PORTFOLIO_PLUS_PARENT', '<span itemprop="genre">' . $title . '</span>'); ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>


                                <?php
                                if ($params->get('show_cat_tags', 0)) :
                                    $document = JFactory::getDocument();
                                    $viewType = $document->getType();
                                    $controller = JControllerLegacy::getInstance('TZ_Portfolio_Plus');
                                    $view       = $controller -> getView('Portfolio',$viewType);
                                    $view -> assign('params',$params);
                                    $view -> assign('item',$item);

                                    echo $view -> loadTemplate('tags');
                                endif;
                                ?>

                                <?php if ($params->get('show_cat_create_date',0)) : ?>
                                    <div class="TzPortfolioDate" itemprop="dateCreated">
                                        <?php echo JText::sprintf('COM_TZ_PORTFOLIO_PLUS_CREATED_DATE_ON', JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC2'))); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($params->get('show_cat_modify_date', 0)) : ?>
                                    <div class="TzPortfolioModified" itemprop="dateModified">
                                        <?php echo JText::sprintf('COM_TZ_PORTFOLIO_PLUS_LAST_UPDATED', JHtml::_('date', $item->modified, JText::_('DATE_FORMAT_LC2'))); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($params->get('show_cat_publish_date',0)) : ?>
                                    <div class="published" itemprop="datePublished">
                                        <?php echo JText::sprintf('COM_TZ_PORTFOLIO_PLUS_PUBLISHED_DATE_ON', JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC2'))); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($params->get('show_cat_author', 0) && !empty($item->author )) : ?>
                                    <div class="TzPortfolioCreatedby" itemprop="author" itemscope itemtype="http://schema.org/Person">
                                        <?php $author =  $item->author; ?>
                                        <?php $author = ($item->created_by_alias ? $item->created_by_alias : $author);?>
                                        <?php $author = '<span itemprop="name">' . $author . '</span>'; ?>

                                        <?php if ($params->get('cat_link_author', 1)):?>
                                            <?php 	echo JText::sprintf('COM_TZ_PORTFOLIO_PLUS_WRITTEN_BY' ,
                                                JHtml::_('link', $item -> author_link, $author, array('itemprop' => 'url'))); ?>
                                        <?php else :?>
                                            <?php echo JText::sprintf('COM_TZ_PORTFOLIO_PLUS_WRITTEN_BY', $author); ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($params->get('show_cat_hits', 0)) : ?>
                                    <div class="TzPortfolioHits">
                                        <?php echo JText::sprintf('COM_TZ_PORTFOLIO_PLUS_ARTICLE_HITS', $item->hits); ?>
                                        <meta itemprop="interactionCount" content="UserPageVisits:<?php echo $item->hits; ?>" />
                                    </div>
                                <?php endif; ?>

                                <?php echo $item -> event -> afterDisplayAdditionInfo; ?>

                            </div>
                            <?php
                        endif;
                        //-- End display some information --//
                        ?>

                        <?php echo $item -> event -> contentDisplayListView; ?>

                        <?php
                        //Call event onContentAfterDisplay on plugin
                        echo $item->event->afterDisplayContent;
                        ?>
                    </div>
                    <?php
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
                    <a href="<?php echo $image_url;?>" class="tzpp_button"
                       data-rel="prettyPhoto[tzpp_image]"
                       title="<?php echo $item -> title;?>">
                        <i class="tzpp_icon tzpp_icon-images"></i>
                    </a><?php
                    if($params -> get('show_cat_readmore',1)):?>
                        <a class="tzpp_button TzPortfolioReadmore<?php if($params -> get('tz_use_lightbox', 1)){
                            echo ' fancybox fancybox.iframe';}?>" href="<?php echo $item ->link; ?>"
                           title="<?php echo JText::_('COM_TZ_PORTFOLIO_PLUS_READ_MORE'); ?>">
                            <i class="tzpp_icon tzpp_icon-link tzpp_icon-rotate-90"></i>
                        </a>
                    <?php endif;?>
                </div>
            </div>
        </div>

        <?php
            // End Description and some info
        endif;?>
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