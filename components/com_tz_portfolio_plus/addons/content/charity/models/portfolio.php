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

class PlgTZ_Portfolio_PlusContentCharityModelPortfolio extends TZ_Portfolio_PlusPluginModelItem{

    public function getItem()
    {
        if($item = parent::getItem()) { // TODO: Change the autogenerated stub

            if(isset($item -> id)) {
                return $item;
            }
        }
    }

    public function getFormDonate(){

        $model  = JModelLegacy::getInstance('Donate','PlgTZ_Portfolio_PlusContentCharityModel');
        $form   = $model -> getForm();

        return $form;

    }

    public function getCurrency() {

        $valueDefault   = (object) array(
                                "title" => 'US.Dollar',
                                "code" => "USD",
                                "sign" => "$",
                                "display" => "0",
                                "position" => "0",
                                "default" => "1",
                                "description" => "");
        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true)
            -> select('*')
            -> from('#__tz_portfolio_plus_addon_data')
            -> where('element=\'currency\' AND value LIKE '.$db -> quote('%"default":"1"%'). ' OR value LIKE '.$db -> quote('%"default":1%'));

        $db -> setQuery($query);
        $currency   = $db -> loadObject();
        if(isset($currency) && !empty($currency)) {
            $value      = json_decode($currency -> value);
        }else {
            $value      = $valueDefault;
        }

        return $value;

    }

    public function getDonated() {

        if($item = parent::getItem()) { // TODO: Change the autogenerated stub

            if(isset($item -> id)){

                $idct   = $item -> id;
                $db     = JFactory::getDbo();
                $query  = $db -> getQuery(true);

                $query  -> select('*')
                    -> from('#__tz_portfolio_plus_addon_data')
                    -> where('element = \'donate\' AND published = 1 AND content_id = '.$idct);

                $db->setQuery($query);

                $row = $db -> loadObjectList();

                $return = array();
                $sumDonate = 0;
                $countD     = count($row);

                foreach($row as $i => $value) {

                    $vDonate    = json_decode($value->value); // money donate
                    $mDonate    = $vDonate->money_donate;
                    $sumDonate  += (int)($mDonate);
                }

                $return['countDonate'] = $countD;
                $return['sumDonate'] = $sumDonate;

                return $return;

            }else {
                return '';
            }
        }else {
            return '';
        }

    }

}