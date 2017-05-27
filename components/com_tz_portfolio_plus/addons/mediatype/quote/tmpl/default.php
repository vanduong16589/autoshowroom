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

$form   = $this -> form;
$group  = 'media.'.$this -> _name;
$quote  = null;
if($this -> item && isset($this -> item -> media)){
    $quote  = $this -> item -> media;
    if(isset($quote[$this -> _name])) {
        $quote = $quote[$this -> _name];
    }
}
?>

<div class="control-group">
    <div class="control-label"><?php echo $form -> getLabel('author',$group);?></div>
    <div class="controls">
        <?php echo $form -> getInput('author',$group);?>
    </div>
</div>
<div class="control-group">
    <div class="control-label"><?php echo $form -> getLabel('text',$group);?></div>
    <div class="controls">
        <?php echo $form -> getInput('text',$group);?>
    </div>
</div>