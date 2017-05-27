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

$params = $this -> item -> params;
$tmpl           = JRequest::getString('tmpl');
?>
<?php if($this -> listTags):?>
<div class="TzArticleTag">
    <div class="title"><?php echo JText::_('COM_TZ_PORTFOLIO_PLUS_TAG_TITLE');?></div>
    <?php foreach($this -> listTags as $i => $item):
        ?><span class="tag-list<?php echo $i ?>" itemprop="keywords"><a<?php
        if(isset($tmpl) AND !empty($tmpl)): echo ' target="_blank"'; endif;
        ?> href="<?php echo $item -> link; ?>"><?php
        echo $item -> title;
        ?></a><?php
        if($i < count($this -> listTags) - 1){echo ',';}
        ?></span><?php
    endforeach;?>
</div>
<?php endif;?>
