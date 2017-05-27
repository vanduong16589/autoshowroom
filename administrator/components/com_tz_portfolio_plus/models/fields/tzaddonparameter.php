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

defined('JPATH_PLATFORM') or die;

jimport('joomla.form.formfieldcheckbox');
JLoader::import('com_tz_portfolio_plus.libraries.plugin.helper',JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components');

class JFormFieldTZAddonParameter extends JFormField
{
    protected $type = "TZAddonParameter";

    public function getLabel(){
        return '';
    }
    public function getInput(){
        return '';
    }

    public function setForm(JForm $form)
    {
//        $fieldsets = $form ->getFieldsets();
//        $fieldset   = $form -> getXml() -> ;
//
//        var_dump($fieldset ->xpath('//field[@type="tzaddonparameter"]')); die();
//        $xpath  = $fieldset ->xpath('/extension/config/fields/fieldset/field[@type="tzaddonparameter"]');
//        var_dump($xpath); die;
//        $path   = COM_TZ_PORTFOLIO_PLUS_ADDON_PATH.DIRECTORY_SEPARATOR.'content'
//            .DIRECTORY_SEPARATOR.'vote'.DIRECTORY_SEPARATOR.'vote.xml';
//        $form -> addFormPath(COM_TZ_PORTFOLIO_PLUS_ADDON_PATH.DIRECTORY_SEPARATOR.'content'
//            .DIRECTORY_SEPARATOR.'vote');
//        $form -> loadFile($path, false,'/extension/config/fields[@name="params"]');
//
//        $this->form = $form;
//        $this->formControl = $form->getFormControl();
//
//        return $this;
    }
}