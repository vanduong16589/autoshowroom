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
<?php endif;?>
<?php 
		
		 $mediatype_icons    = array('image' => 'tzpp_icon tzpp_icon-image',
                       'image_gallery' => 'tzpp_icon tzpp_icon-images', 'video' => 'tzpp_icon tzpp_icon-film'
                   , 'audio' => 'tzpp_icon tzpp_icon-volume-medium');
        ?>
		<div class="TzButtonAction">
			<?php if(isset($mediatype_icons[$item -> type])){?>
				<a href="<?php echo $image -> url;?>" class="tz_button_action white left" data-rel="prettyPhoto[pp_gal]"> 				
					<i class="<?php echo $mediatype_icons[$item -> type]?>"></i>
				</a>
			<?php }?>
			<a class="tz_button_action black right" href="<?php echo $item ->link; ?>"  itemprop="url">
				<i class="tzpp_icon tzpp_icon-link tzpp_icon-rotate-90"></i>
			</a>
			
		</div>

<?php
        if(!isset($item -> mediatypes) || (isset($item -> mediatypes) && !in_array($item -> type,$item -> mediatypes))):
        // Start Description and some info
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
        <div class="TzPortfolioDescription">
            <div class="tzpp_table">
                <div class="tzpp_table-cell">

                <?php
                ?>
				<a href="<?php echo $image_url;?>" class="tzpp_button" data-rel="prettyPhoto[tzpp_image]"
                    title="<?php echo $item -> title;?>">
                    <i class="tzpp_icon tzpp_icon-image"></i>
                </a>
                <?php if($params -> get('show_cat_readmore',1)):?>
                <a class="tzpp_button TzPortfolioReadmore<?php if($params -> get('tz_use_lightbox', 1)){
                    echo ' fancybox fancybox.iframe';}?>" href="<?php echo $item ->link; ?>"
                   title="<?php echo JText::_('COM_TZ_PORTFOLIO_PLUS_READ_MORE'); ?>">
                    <i class="tzpp_icon tzpp_icon-link tzpp_icon-rotate-90"></i>
                </a>
                <?php endif;?>

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

                </div>
            </div>
        </div>
        <?php
        // End Description and some info
        endif;?>		
		
		
		