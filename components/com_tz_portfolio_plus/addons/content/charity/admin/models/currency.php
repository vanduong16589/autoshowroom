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

use Joomla\Registry\Registry;

class TZ_Portfolio_Plus_Addon_CharityModelCurrency extends TZ_Portfolio_PlusModelAddon_Data
{
    protected $addon_element   = 'currency';

    public function setHome($id = 0)
    {

        $user = JFactory::getUser();
        $db   = $this->getDbo();

        // Access checks.
        if (!$user->authorise('core.edit.state', 'com_tz_portfolio_plus'))
        {
            throw new Exception(JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'));
        }

//        $style = JTable::getInstance('Style', 'TemplatesTable');

        $addonData  = $this -> getTable();

        if (!$addonData->load((int) $id))
        {
            throw new Exception(JText::_('COM_TEMPLATES_ERROR_STYLE_NOT_FOUND'));
        }

        // Get data with home
        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true)
            -> select('*')
            -> from('#__tz_portfolio_plus_addon_data')
            -> where('value LIKE '.$db -> quote('%"default":"1"%'),'OR')
            -> where('value LIKE '.$db -> quote('%"default":1%'));
        $db -> setQuery($query);

        $homeData = $db -> loadObjectList();
        if($homeData){
            // un default
            foreach($homeData as $hi => $hdata) {
                $homeValue          = json_decode($hdata -> value);
                $homeValue->default = "0";
                $homeId             = $hdata -> id;
                $registry           = new Registry;
                $registry->loadObject($homeValue);
                $homeValue  = (string) $registry;
                self::unDefault($homeValue,$homeId);
            }
        }

        // Set the new default currency.

        $addonValue = json_decode($addonData -> value);
        $addonValue ->default   = "1";
        $addonValue = json_encode($addonValue);
        $query -> clear();
        $query -> update('#__tz_portfolio_plus_addon_data')
            -> set('value='.$db -> quote($addonValue))
            -> where('id='.$id);
        $db -> setQuery($query);
        $db -> execute();

        // Clean the cache.
        $this->cleanCache();

        return true;
    }

    public function unDefault($homeValue,$homeId) {

        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);
        $query -> update('#__tz_portfolio_plus_addon_data')
                -> set('value='.$db -> quote($homeValue))
                -> where('id='.$homeId);
        $db -> setQuery($query);
        $db -> execute();

        return true;

    }

    public function save($data)
    {
        $dispatcher = JEventDispatcher::getInstance();
        $table      = $this->getTable();
        $context    = $this->option . '.' . $this->name;

        if ((!empty($data['tags']) && $data['tags'][0] != ''))
        {
            $table->newTags = $data['tags'];
        }

        $key = $table->getKeyName();
        $pk = (!empty($data[$key])) ? $data[$key] : (int) $this->getState($this->getName() . '.id');
        $isNew = true;

        // Include the plugins for the save events.
        JPluginHelper::importPlugin($this->events_map['save']);

        // Allow an exception to be thrown.
        try
        {
            // Load the row if saving an existing record.
            if ($pk > 0)
            {
                $table->load($pk);
                $isNew = false;
            }

            // Bind the data.
            if (!$table->bind($data))
            {
                $this->setError($table->getError());

                return false;
            }

            // Prepare the row for saving
            $this->prepareTable($table);

            // Check the data.
            if (!$table->check())
            {
                $this->setError($table->getError());

                return false;
            }

            // Trigger the before save event.
            $result = $dispatcher->trigger($this->event_before_save, array($context, $table, $isNew));

            if (in_array(false, $result, true))
            {
                $this->setError($table->getError());

                return false;
            }

            // Store the data.
            if (!$table->store())
            {
                $this->setError($table->getError());

                return false;
            }

            // Clean the cache.
            $this->cleanCache();

            // Trigger the after save event.
            $dispatcher->trigger($this->event_after_save, array($context, $table, $isNew));
        }
        catch (Exception $e)
        {
            $this->setError($e->getMessage());

            return false;
        }

        if (isset($table->$key))
        {
            $this->setState($this->getName() . '.id', $table->$key);
        }

        $this->setState($this->getName() . '.new', $isNew);

        if ($this->associationsContext && JLanguageAssociations::isEnabled())
        {
            $associations = $data['associations'];

            // Unset any invalid associations
            $associations = Joomla\Utilities\ArrayHelper::toInteger($associations);

            // Unset any invalid associations
            foreach ($associations as $tag => $id)
            {
                if (!$id)
                {
                    unset($associations[$tag]);
                }
            }

            // Show a notice if the item isn't assigned to a language but we have associations.
            if ($associations && ($table->language == '*'))
            {
                JFactory::getApplication()->enqueueMessage(
                    JText::_(strtoupper($this->option) . '_ERROR_ALL_LANGUAGE_ASSOCIATED'),
                    'notice'
                );
            }

            // Adding self to the association
            $associations[$table->language] = (int) $table->$key;

            // Deleting old association for these items
            $db    = $this->getDbo();
            $query = $db->getQuery(true)
                ->delete($db->qn('#__associations'))
                ->where($db->qn('context') . ' = ' . $db->quote($this->associationsContext))
                ->where($db->qn('id') . ' IN (' . implode(',', $associations) . ')');
            $db->setQuery($query);
            $db->execute();

            if ((count($associations) > 1) && ($table->language != '*'))
            {
                // Adding new association for these items
                $key   = md5(json_encode($associations));
                $query = $db->getQuery(true)
                    ->insert('#__associations');

                foreach ($associations as $id)
                {
                    $query->values(((int) $id) . ',' . $db->quote($this->associationsContext) . ',' . $db->quote($key));
                }

                $db->setQuery($query);
                $db->execute();
            }
        }


        //////////////////////// un Default ////////////////////////
        // Get data with home
        $idNew      = $data['id'];
        $valueNew   = $data['value'];
        $newDefault = $valueNew['default'];
        if(isset($newDefault) && $newDefault == 1) {
            $db     = $this -> getDbo();
            $query  = $db -> getQuery(true)
                -> select('*')
                -> from('#__tz_portfolio_plus_addon_data')
                -> where('value LIKE '.$db -> quote('%"default":"1"%'))
                -> where('id != '.$idNew);
            $db -> setQuery($query);
            $homeData = $db -> loadObjectList();
            if($homeData){
                // un default
                foreach($homeData as $hi => $hdata) {
                    $homeValue          = json_decode($hdata -> value);
                    $homeValue->default = "0";
                    $homeId             = $hdata -> id;
                    $registry           = new Registry;
                    $registry->loadObject($homeValue);
                    $homeValue  = (string) $registry;
                    self::unDefault($homeValue,$homeId);
                }
            }
        }

        return true;
    }

}