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

defined('_JEXEC') or die();

$doc    = JFactory::getDocument();

if($this -> items):
?>
    <?php foreach($this -> items as $i => $item):
        $this -> item   = $item;
        $params         = $item -> params;

        if($params -> get('tz_column_width',230))
            $tzItemClass    = ' tz_item';
        else
            $tzItemClass    = null;

        if($item -> featured == 1)
            $tzItemFeatureClass    = ' tz_feature_item';
        else
            $tzItemFeatureClass    = null;

        $class  = '';
        if($params -> get('tz_filter_type','tags') == 'tags'){
            if($item -> tags && count($item -> tags)){
                $alias  = JArrayHelper::getColumn($item -> tags, 'alias');
                $class  = implode(' ', $alias);
            }
        }
        elseif($params -> get('tz_filter_type','tags') == 'categories'){
            $class  = 'category'.$item -> catid;
            if(isset($item -> second_categories) && $item -> second_categories &&  count($item -> second_categories)) {
                foreach($item -> second_categories as $category){
                    $class  .= ' category'.$category -> id;
                }
            }
        }
        elseif($params -> get('tz_filter_type','tags') == 'letters'){
            $class  = mb_strtolower(mb_substr(trim($item -> title),0,1));
        }
    ?>
<div id="tzelement<?php echo $item -> id;?>"
     data-date="<?php echo strtotime($item -> created); ?>"
     data-title="<?php echo $this->escape($item -> title); ?>"
     data-hits="<?php echo (int) $item -> hits; ?>"
     class="element <?php echo $class.$tzItemClass.$tzItemFeatureClass;?>"
     itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">

    <div class="TzInner">

        <?php
        // Display media from plugin of group tz_portfolio_plus_mediatype
        echo $this -> loadTemplate('media');
        ?>

        
    </div>
</div>

    <?php endforeach;?>
<?php endif;?>
