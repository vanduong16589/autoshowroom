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
defined('_JEXEC') or die;

JHtml::addIncludePath(COM_TZ_PORTFOLIO_PLUS_ADMIN_HELPERS_PATH.DIRECTORY_SEPARATOR.'html');

$user		= JFactory::getUser();

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$saveOrder	= $listOrder == 'ordering';

$addonId    = $this -> state -> get($this -> getName().'.addon_id');

if ($saveOrder)
{
    $saveOrderingUrl = TZ_Portfolio_PlusHelperAddon_Datas::getRootURL($addonId)
        .'&addon_task=amounts.saveOrderAjax&tmpl=component';
    JHtml::_('tzsortablelist.sortable', 'addonDataList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>
<form action="<?php echo JRoute::_(TZ_Portfolio_PlusHelperAddon_Datas::getRootURL($addonId).'&addon_view=amounts');?>"
      method="post" name="adminForm" id="adminForm">

    <?php
    if(!empty($this -> sidebar)){
    ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this -> sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
    <?php }else{?>
    <div id="j-main-container">
        <?php }?>
        <div id="filter-bar" class="btn-toolbar">
            <div class="btn-group pull-right hidden-phone">
                <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
                <?php echo $this->pagination->getLimitBox(); ?>
            </div>
        </div>
        <table class="table table-striped"  id="addonDataList">
            <thead>
            <tr>
                <th width="1%" class="nowrap center">
                    <?php echo JHtml::_('grid.sort','<span class="icon-menu-2"></span>','ordering',$listDirn,$listOrder,null,'asc','JGRID_HEADING_ORDERING');?>
                </th>
                <th width="1%" class="hidden-phone">
                    <?php echo JHtml::_('grid.checkall');?>
                </th>
                <th width="1%" class="nowrap center" style="min-width: 55px;">
                    <?php echo JHtml::_('grid.sort','JSTATUS','published',$listDirn,$listOrder);?>
                </th>
                <th class="nowrap">
                    <?php echo JHtml::_('grid.sort','JGLOBAL_TITLE','value.title',$listDirn,$listOrder);?>
                </th>
                <th class="nowrap">
                    <?php echo JHtml::_('grid.sort','JGLOBAL_FIELDSET_DISPLAY_PRICE','value.price',$listDirn,$listOrder);?>
                </th>
                <th class="nowrap" width="1%">
                    <?php echo JHtml::_('grid.sort','JGRID_HEADING_ID','id',$listDirn,$listOrder);?>
                </th>
            </tr>
            </thead>

            <?php if($items = $this->items): ?>
            <tbody>

            <?php foreach($items as $i => $data):
                $canCreate  = $user->authorise('core.create',   'com_tz_portfolio_plus');
                $canEdit    = $user->authorise('core.edit',     'com_tz_portfolio_plus');
                $canEditOwn = $user->authorise('core.edit.own', 'com_tz_portfolio_plus');
                $item       = $data->value;
            ?>
                <tr class="row<?php echo $i%2;?>" sortable-group-id="<?php echo $data->extension_id;?>">
                    <td class="order nowrap center hidden-phone">
                        <?php
                            $canChange  = $user->authorise('core.edit.state','com_tz_portfolio_plus.addons');
                            $iconClass  = '';
                            if($canChange) {
                                $iconClass  = ' inactive';
                            }elseif(!$saveOrder) {
                                $iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
                            }
                        ?>
                        <span class="sortable-handler<?php echo $iconClass;?>">
                            <span class="icon-menu"></span>
                        </span>
                        <?php if($canChange && $saveOrder):?>
                            <input type="text" style="display: none" name="order[]" size="5" />
                        <?php endif;?>
                    </td>
                    <td class="center">
                        <?php echo JHtml::_('grid.id', $i,$data->id,false,'cid');?>
                    </td>
                    <td class="center">
                        <div class="btn-group">
                            <?php echo JHtml::_('jgrid.published',$data->published,$i,'amounts.',true,'cb');?>
                        </div>
                    </td>
                    <td>
                        <?php if($canEdit || $canEditOwn):?>
                            <a href="<?php echo JRoute::_(TZ_Portfolio_PlusHelperAddon_Datas::getRootURL($addonId)
                            .'&addon_task=amount.edit&id='.(int)$data->id);?>">
                                <?php echo $this->escape($item->title);?>
                            </a>
                        <?php endif;?>
                    </td>
                    <td>
                        <?php echo $item -> price;?>
                    </td>
                    <td width="1%">
                        <?php echo $data -> id;?>
                    </td>
                </tr>
            <?php
            endforeach; ?>

            </tbody>
            <?php endif;?>

            <tfoot>
            <tr>
                <td colspan="6">
                    <?php echo $this -> pagination -> getListFooter();?>
                </td>
            </tr>
            </tfoot>
        </table>

    </div>

        <input type="hidden" name="boxchecked" value="0">
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <input type="hidden" name="addon_task" value="" />
        <?php echo JHtml::_('form.token'); ?>

</form>

















