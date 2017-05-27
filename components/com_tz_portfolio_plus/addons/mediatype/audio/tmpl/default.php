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

$form   = $this -> form;
$group  = 'media.'.$this -> _name;
$audio  = null;
if($this -> item && isset($this -> item -> media)){
    $media  = $this -> item -> media;
    if(isset($media[$this -> _name])) {
        $audio = $media[$this -> _name];
    }
}

$doc    = JFactory::getDocument();
$doc -> addScriptDeclaration('
(function($){
    $(document).ready(function(){
        TzPortfolioMediaTypeAudioProcess($("#jform_media_audio_type"));
        $("#jform_media_audio_type").bind("change",function(e){
            TzPortfolioMediaTypeAudioProcess($(this));
        });
        function TzPortfolioMediaTypeAudioProcess(obj){
            if(obj.val() == "embed"){
                $("#jform_media_audio_embed_code").parents(".control-group").first().show();
                $("#jform_media_audio_code").parents(".control-group").first().hide();
            }else{
                $("#jform_media_audio_code").parents(".control-group").first().show();
                $("#jform_media_audio_embed_code").parents(".control-group").first().hide();
            }
        }
    });
})(jQuery);
');
?>
<div class="control-group">
    <div class="control-label"><?php echo $form -> getLabel('type',$group);?></div>
<div class="controls">
    <?php echo $form -> getInput('type',$group);?>
</div>
</div>
<div class="control-group">
    <div class="control-label"><?php echo $form -> getLabel('code',$group);?></div>
    <div class="controls">
        <?php echo $form -> getInput('code',$group);?>
    </div>
</div>
<div class="control-group">
    <div class="control-label"><?php echo $form -> getLabel('embed_code',$group);?></div>
    <div class="controls">
        <?php echo $form -> getInput('embed_code',$group);?>
    </div>
</div>
<div class="control-group">
    <div class="control-label"><?php echo $form -> getLabel('thumbnail',$group);?></div>
    <div class="controls">
        <?php echo $form -> getInput('thumbnail',$group);?>

        <?php
        if($audio && isset($audio['thumbnail']) && !empty($audio['thumbnail'])){
            ?>
            <div class="control-group">
                <?php
                echo $form -> getInput('thumbnail_remove',$group,$audio['thumbnail']);
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<div class="control-group">
    <div class="control-label"><?php echo $form -> getLabel('caption',$group);?></div>
    <div class="controls">
        <?php echo $form -> getInput('caption',$group);?>
    </div>
</div>