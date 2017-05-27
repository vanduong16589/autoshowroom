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
    if($params -> get('mt_image_related_show_image', 1)):
?>

<?php
    $crt_cf_size = $params->get('mt_image_related_size','');
    if($crt_cf_size != '') {
        $crt_file = JFile::getExt($image -> url);
        $csrt_serch_rep = '_'.$crt_cf_size.'.'.$crt_file;
        $crt_rpl = '_o.'.$crt_file;
        $crt_src_image = str_replace($csrt_serch_rep,$crt_rpl,$image -> url);
    }else {
        $crt_src_image = $image -> url;
    }
?>

<div class="TzImage">
    <a<?php echo $params -> get('tz_use_lightbox', 1)?' class="fancybox fancybox.iframe"':'';?>
        href="<?php echo $item -> link;?>">
        <img src="<?php echo $image -> related_url;?>"
             alt="<?php echo isset($image -> caption)?$image -> caption:$item -> title;?>"
             title="<?php echo isset($image -> caption)?$image -> caption:$item -> title;?>"
             itemprop="thumbnailUrl"/>
    </a>
	<div class="tz-absolute">
        <div class="tz-table">
            <div class="tz-table-cell">
                <a href="<?php echo $crt_src_image;?>" data-rel="prettyPhoto"><i class="fa fa-search"></i></a>
				<a href="<?php echo $item -> link;?>"><i class="fa fa-link"></i></a>
            </div>
        </div>
    </div>
</div>
<?php
    endif;
endif;