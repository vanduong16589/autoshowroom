<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Extension

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# Copyright: Copyright (C) 2015 templaza.com. All Rights Reserved.

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

require_once(COM_TZ_PORTFOLIO_PLUS_ADMIN_PATH.'/views/addon_datas/view.html.php');

class TZ_Portfolio_Plus_Addon_CharityViewCurrencies extends JViewLegacy{

    protected $state;
    protected $items;
    protected $form;
    protected $sidebar;
    protected $pagination;

    public function display($tpl=null){

        $this->state        = $this->get('State');
        $this->items        = $this->get('Items');
        $this->pagination   = $this->get('pagination');

        TZ_Portfolio_Plus_Addon_CharityHelpers::addSubmenu('currencies');

        $this->addToolbar();

        $this -> sidebar    = JHtmlSidebar::render();

        parent::display($tpl);
    }

    protected function addToolbar(){
        $canDo	= JHelperContent::getActions('com_tz_portfolio_plus');

        if ($canDo->get('core.create') ) {
            JToolBarHelper::addNew('currency.add');
        }

        JToolBarHelper::editList('currency.edit');
        JToolBarHelper::divider();
        JToolBarHelper::publish('currencies.publish', 'JTOOLBAR_PUBLISH', true);
        JToolBarHelper::unpublish('currencies.unpublish', 'JTOOLBAR_UNPUBLISH', true);

        if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete')) {
            JToolBarHelper::deleteList('', 'currencies.delete', 'JTOOLBAR_EMPTY_TRASH');
            JToolBarHelper::divider();
        }
        elseif ($canDo->get('core.edit.state')) {
            JToolBarHelper::trash('currencies.trash');
            JToolBarHelper::divider();
        }

        JHtmlSidebar::addFilter(
            JText::_('JOPTION_SELECT_PUBLISHED'),
            'filter_published',
            JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('archived' => false)), 'value', 'text', $this->state->get('filter.published'), true)
        );
    }
}