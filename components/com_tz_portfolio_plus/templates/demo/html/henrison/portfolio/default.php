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

//no direct access
defined('_JEXEC') or die();

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');

$doc        = JFactory::getDocument();
$app        = JFactory::getApplication('site');
$input      = $app -> input;
$tzTemplate = TZ_Portfolio_PlusTemplate::getTemplate(true);
$tplParams  = $tzTemplate -> params;

$doc -> addScript(TZ_Portfolio_PlusUri::base(true).'/templates/'.$tzTemplate -> template.'/js/resize.js');
$doc -> addScriptDeclaration('
jQuery(function($){
    $(document).ready(function(){
        $("#portfolio").tzPortfolioPlusIsotope({
            "params": '.$this -> params .',
            "afterColumnWidth" : function(newColCount,newColWidth){
                '.($tplParams -> get('enable_resize_image', 1)?'TzTemplateDemoResizeImage($("#portfolio > .element .TzArticleMedia"));':'').'
            }
        });
        $("#tz_options .option-set a").click(function(){
              $(this).parents(".dropdown").first()
              .find(".dropdown-toggle")
              .html($(this).text() + \' <span class="fa fa-angle-down option-icon"></span>\')
              .end().removeClass("open")
              .find(".dropdown-menu").removeClass("open");
        });
    });
    $(window).load(function(){
        var $tzppisotope    = $("#portfolio").data("tzPortfolioPlusIsotope");
        $tzppisotope.imagesLoaded(function(){
            $tzppisotope.tz_init();
        });
    });
});
');

if($colHeight = $tplParams -> get('column_height')){
    $doc -> addStyleDeclaration('.element .TzArticleMedia{
        height: '.$colHeight.'px;
    }');
}
?>

<?php if($this -> items):?>

    <?php
    $params = &$this -> params;
?>
<div id="TzContent" class="tzpp_bootstrap3 <?php echo $this->pageclass_sfx;?> layout_henrison">
    <?php if ($params->get('show_page_heading', 1)) : ?>
        <h1 class="page-heading">
            <?php echo $this->escape($params->get('page_heading')); ?>
        </h1>
    <?php endif; ?>

    <?php if($params -> get('use_filter_first_letter',0)):?>
        <div class="TzLetters">
            <div class="breadcrumb">
                <?php echo $this -> loadTemplate('letters');?>
            </div>
        </div>
    <?php endif;?>

    <div id="tz_options" class="clearfix">
        <?php if($params -> get('tz_show_filter',1)):?>
            <div class="option-combo">
                <div class="dropdown">
                    <a href="javascript: void(0)" data-toggle="dropdown"
                       data-target="#filter"
                       aria-haspopup="true"
                       aria-expanded="true"
                       class="btn btn-default btn-sm dropdown-toggle">
                        <?php echo JText::_('COM_TZ_PORTFOLIO_PLUS_FILTER');?><span class="fa fa-angle-down option-icon"></span>
                    </a>
                    <div id="filter" class="dropdown-menu option-set clearfix"  data-option-key="filter">
                        <a href="#show-all" data-option-value="*" class="btn btn-default btn-sm selected"><?php echo JText::_('COM_TZ_PORTFOLIO_PLUS_SHOW_ALL');?></a>
                        <?php if($params -> get('tz_filter_type','tags') == 'tags'):?>
                            <?php echo $this -> loadTemplate('filter_tags');?>
                        <?php endif;?>
                        <?php if($params -> get('tz_filter_type','tags') == 'categories'):?>
                            <?php echo $this -> loadTemplate('filter_categories');?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        <?php endif;?>

        <?php if($params -> get('show_sort',0) AND $sortfields = $params -> get('sort_fields',array('date','hits','title'))):
            $sort   = $params -> get('orderby_sec','rdate');
            ?>
            <div class="option-combo">
                <div class="dropdown">
                    <a href="javascript: void(0)" data-toggle="dropdown"
                       data-target="#sort"
                       aria-haspopup="true"
                       aria-expanded="true"
                       class="btn btn-default btn-sm dropdown-toggle">
                        <?php echo JText::_('COM_TZ_PORTFOLIO_PLUS_SORT');?><span class="fa fa-angle-down option-icon"></span>
                    </a>
                    <div id="sort" class="dropdown-menu option-set clearfix" data-option-key="sortBy">
                        <?php
                        foreach($sortfields as $sortfield):
                            switch($sortfield):
                                case 'title':
                                    ?>
                                    <a class="btn btn-default btn-sm<?php echo ($sort == 'alpha' || $sort == 'ralpha')?' selected':''?>"
                                       href="#title" data-option-value="name"><?php echo JText::_('COM_TZ_PORTFOLIO_PLUS_TITLE');?></a>
                                    <?php
                                    break;
                                case 'date':
                                    ?>
                                    <a class="btn btn-default btn-sm<?php echo ($sort == 'date' || $sort == 'rdate')?' selected':''?>"
                                       href="#date" data-option-value="date"><?php echo JText::_('COM_TZ_PORTFOLIO_PLUS_DATE');?></a>
                                    <?php
                                    break;
                                case 'hits':
                                    ?>
                                    <a class="btn btn-default btn-sm<?php echo ($sort == 'hits' || $sort == 'rhits')?' selected':''?>"
                                       href="#hits" data-option-value="hits"><?php echo JText::_('JGLOBAL_HITS');?></a>
                                    <?php
                                    break;
                            endswitch;
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        <?php endif;?>

        <?php if($params -> get('show_layout',0)):?>
            <div class="option-combo">
                <div class="filter-title"><?php echo JText::_('COM_TZ_PORTFOLIO_PLUS_LAYOUT');?></div>
                <div id="layouts" class="option-set clearfix" data-option-key="layoutMode">
                    <?php
                    if(count($params -> get('layout_type',array('masonry','fitRows','straightDown')))>0):
                        foreach($params -> get('layout_type',array('masonry','fitRows','straightDown')) as $i => $param):
                            ?>
                            <a class="btn btn-default btn-sm<?php if($i == 0) echo ' selected';?>" href="#<?php echo $param?>" data-option-value="<?php echo $param?>">
                                <?php echo $param?>
                            </a>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
        <?php endif;?>

        <?php if($params -> get('tz_portfolio_plus_layout', 'ajaxButton') == 'default'):?>
            <?php if($params -> get('show_limit_box',1)):?>
                <div class="TzShow">
                    <span class="title"><?php echo strtoupper(JText::_('JSHOW'));?></span>
                    <form name="adminForm" method="post" id="TzShowItems"
                          action="<?php echo JRoute::_('index.php?option=com_tz_portfolio_plus&view=portfolio&Itemid='.$this -> Itemid);?>">
                        <?php echo $this -> pagination -> getLimitBox();?>
                    </form>
                </div>
            <?php endif;?>
        <?php endif;?>
    </div>

    <div id="portfolio" class="super-list variable-sizes clearfix"
         itemscope itemtype="http://schema.org/Blog">
        <?php echo $this -> loadTemplate('item');?>
    </div>

    <?php if($params -> get('tz_portfolio_plus_layout', 'ajaxButton') == 'default'):?>
        <?php if (($params->def('show_pagination', 1) == 1  || ($params->get('show_pagination', 1) == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
            <div class="pagination">
                <?php  if ($params->def('show_pagination_results', 1)) : ?>
                    <p class="counter">
                        <?php echo $this->pagination->getPagesCounter(); ?>
                    </p>
                <?php endif; ?>

                <?php echo $this->pagination->getPagesLinks(); ?>
            </div>
            <div class="clearfix"></div>
        <?php endif;?>
    <?php endif;?>

    <?php if($params -> get('tz_portfolio_plus_layout', 'ajaxButton') == 'ajaxButton'
        || $params -> get('tz_portfolio_plus_layout', 'ajaxButton') == 'ajaxInfiScroll'):?>
        <?php echo $this -> loadTemplate('infinite_scroll');?>
    <?php endif;?>

</div>
<?php
endif;