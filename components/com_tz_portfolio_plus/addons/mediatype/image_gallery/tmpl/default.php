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

$form           = $this -> form;
$group          = 'media.'.$this -> _name;
$image_gallery   = null;
$slider_key_max = -1;
if($this -> item && isset($this -> item -> media)){
    $image_gallery   = $this -> item -> media;
    if(isset($image_gallery[$this -> _name])) {
        $image_gallery   = $image_gallery[$this -> _name];
    }else{
        $image_gallery   = null;
    }
}

?>

<div class="control-group">
    <button class="btn tz_btn-add" type="button"><i class="icon-plus"></i><?php echo JText::_('PLG_MEDIATYPE_IMAGE_GALLERY_ADD_NEW');?></button>
</div>

<table class="table table-bordered">
    <thead>
    <tr>
        <th style="text-align: center; width: 5%;"><?php echo JText::_('#');?></th>
        <th><?php echo JText::_('PLG_MEDIATYPE_IMAGE_GALLERY_IMAGE_LABEL');?></th>
        <th><?php echo JText::_('PLG_MEDIATYPE_IMAGE_GALLERY_CAPTION_LABEL');?></th>
        <th style="text-align: center; width: 10%;"><?php echo JText::_('JSTATUS');?></th>
    </tr>
    </thead>
    <tbody>

    <?php ob_start();?>
    <tr>
        <td style="text-align: center; vertical-align: middle;"><i style="cursor: move;" class="icon-move"></i></td>

        <td>
            <div class="tz_control-group">
                <?php echo $form -> getInput('url',$group,'');?>
            </div>
        </td>
        <td>
            <div class="tz_control-group">
                <?php echo $form -> getInput('caption',$group,'');?>
            </div>
        </td>
        <td style="text-align: center;">
            <a class="btn btn-danger tz_btn-remove"
               href="javascript:"><i class="icon-cancel"></i><?php echo JText::_('COM_TZ_PORTFOLIO_PLUS_REMOVE');?>
            </a>
        </td>
    </tr>
    <?php
    $html = ob_get_contents();
    ob_end_clean();
    if($this -> item):
        ?>
        <?php
        if(isset($image_gallery['url'])
            && $image_gallery['url'] && count($image_gallery['url'])) :
            $slider_key_max = PlgTZ_Portfolio_PlusMediaTypeImage_GalleryLibrary::getMaxKey($image_gallery['url']);

            foreach($image_gallery['url'] as $i => $url):
                $caption    = isset($image_gallery['caption'][$i])?$image_gallery['caption'][$i]:'';
                $form->setFieldAttribute('url', 'index', $i, $group);
                $form->setFieldAttribute('caption', 'index', $i, $group);
                $form->setFieldAttribute('url_remove', 'index', $i, $group);
        ?>
        <tr>
            <td style="text-align: center; vertical-align: middle;"><i style="cursor: move;" class="icon-move"></i></td>
            <td>
                <div class="tz_control-group">
                    <?php echo $form -> getInput('url',$group,$url);?>

                    <?php
                    if($image_gallery && isset($image_gallery['url']) && !empty($image_gallery['url'])){
                        ?>
                        <div class="control-group">
                            <?php
                            echo $form -> getInput('url_remove',$group,$url);
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </td>
            <td>
                <div class="tz_control-group">
                    <?php echo $form -> getInput('caption',$group,$caption);?>
                </div>
            </td>
            <td style="text-align: center;">
            </td>
        </tr>
                <?php
            endforeach;
        endif;
        ?>
    <?php else:?>
    <tr>
        <td style="text-align: center; vertical-align: middle;"><i style="cursor: move;" class="icon-move"></i></td>
        <td>
            <div class="tz_control-group">
                <?php echo $form -> getInput('url',$group);?>
            </div>
        </td>
        <td>
            <div class="tz_control-group">
                <?php echo $form -> getInput('caption',$group);?>
            </div>
        </td>
        <td style="text-align: center;">
            <a class="btn btn-danger tz_btn-remove"
               href="javascript:"><i class="icon-cancel"></i><?php echo JText::_('COM_TZ_PORTFOLIO_PLUS_REMOVE');?>
            </a>
        </td>
    </tr>
    <?php endif;?>
    </tbody>
</table>
<script type="text/javascript">
    (function($){
        $(document).ready(function(){
            var $mt_image_gallery_key_max    = <?php echo $slider_key_max;?>;
            function tz_portfolio_plusImage_GalleryRemove() {
                $("#tztabsaddonsplg_<?php echo $this -> _type.$this -> _name; ?> .tz_btn-remove").off("click").on("click", function () {
                    $(this).parents("tr").first().remove();
                });
            }

            tz_portfolio_plusImage_GalleryRemove();
            $("#tztabsaddonsplg_<?php echo $this -> _type.$this -> _name; ?> .tz_btn-add").bind("click",function(){
                $mt_image_gallery_key_max++;
                var $html   = $("<?php echo jsPlusAddSlashes($html);?>");
                if($html.find("[name]").length){
                    $html.find("[name]").each(function(){
                        var $name   = $(this).attr("name");
                        $(this).attr("name",$name.replace(/\[\]$/,'['+ $mt_image_gallery_key_max +']'));
                    });
                }
                $('#tztabsaddonsplg_<?php echo $this -> _type.$this -> _name; ?> .table tbody').prepend($html);
                tz_portfolio_plusImage_GalleryRemove();
            });
            // Sortable
            $("#tztabsaddonsplg_<?php echo $this -> _type.$this -> _name;?> tbody").sortable({
                items               : "> tr",
                cursor              : "move",
                placeholder         : "ui-state-highlight",
                handle              : '.icon-move',
                forcePlaceholderSize: true,
                forceHelperSize     : true
            });
        });
    })(jQuery);
</script>
