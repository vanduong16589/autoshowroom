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

// No direct access
defined('_JEXEC') or die;

if($item   = $this -> item){
    if(isset($this -> quote) && $quote   = $this -> quote){
        $params = $this -> params;
?>
<div class="TzQuote">
    <?php if($params -> get('show_quote_text',1)):?>
        <div class="text"><i class="icon-quote"></i><?php echo $quote -> text;?></div>
    <?php endif;?>

    <?php if($params -> get('show_quote_author',1)):?>
        <span class="muted author"><?php echo JText::sprintf('PLG_MEDIATYPE_QUOTE_AUTHOR',$quote -> author);?></span>
    <?php endif;?>
</div>

<?php } }?>