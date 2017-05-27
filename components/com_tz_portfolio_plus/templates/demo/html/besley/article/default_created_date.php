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
defined('_JEXEC') or die;

$params = $this -> item -> params;
if(isset($this -> item -> created)){
?>
<span class="TzCreate" itemprop="dateCreated">
    <?php echo JHtml::_('date', $this->item->created, JText::_('DATE_FORMAT_LC3')); ?>
</span>
<?php }