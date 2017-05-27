<?php
/*------------------------------------------------------------------------

# Pricing Add-on

# ------------------------------------------------------------------------

# author    TuanNATemPlaza

# copyright Copyright (C) 2015 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

//no direct access
defined('_JEXEC') or die('Restricted access');

class TZ_Portfolio_PlusExtraFieldPricing extends TZ_Portfolio_PlusExtraField
{

    protected $multiple_option  = false;
    protected $add_head         = false;

    public function getInput($fieldValue = null, $group = null)
    {

        if (!$this->isPublished()) {
            return "";
        }

        $this->setAttribute("class", $this->getInputClass(), "input");

        if ((int)$this->params->get("size")) {
            $this->setAttribute("size", (int)$this->params->get("size"), "input");
        }
        $this->setAttribute("type", "number", "input");
        $this->setAttribute("step", "any", "input");

        if ($this->params->get("placeholder", "")) {
            $placeholder = htmlspecialchars($this->params->get("placeholder", ""), ENT_COMPAT, 'UTF-8');
            $this->setAttribute("placeholder", $placeholder, "input");
        }

        $values = !is_null($fieldValue) ? $fieldValue : (string)$this->value;
        $this->setAttribute('value', $values, 'input');

        return parent::getInput($fieldValue);
    }

    public function getSearchName()
    {

        return 'fields[' . $this->id . '][]';

    }

    public function getOutput($options = array())
    {
        return parent::getOutput($options);
    }

    public function getListing($options = array())
    {
        return parent::getListing($options);
    }

    public function getSearchInput($defaultValue = '')
    {
        if (!$this->add_head) {
            $this->add_head = true;
            $this->setVariable('add_head', $this->add_head);
        }

        if (!$this->isPublished()) {
            return '';
        }

        if ($this->getAttribute('type', '', 'search') == '') {
            $this->setAttribute('type', 'text', 'search');
        }

        $this->setVariable('defaultValue', $defaultValue);
        $params = $this->params;
        $options_min    = null;
        $options_max    = null;

        if(strpos($params->get('min_values'),',') != false) {
            $options_min = explode(',', $params->get('min_values'));
        }
        if(strpos($params->get('max_values'),',') != false) {
            $options_max = explode(',', $params->get('max_values'));
        }
        $app = JFactory::getApplication();
        $input = $app->input;
        if ($datasearch = $input->get('fields', array(), 'array')) {
            if (isset($datasearch[$this->id]) && !empty($datasearch[$this->id])) {
                $defaultValue = $datasearch[$this->id];
            }
        }
        if ($params->get('tztype', 1) == 1) {
            $value_min = !is_null($defaultValue) && $defaultValue ? $defaultValue[0] : '';
            $value_max = !is_null($defaultValue) && $defaultValue ? $defaultValue[1] : '';
            $arr_max = array();

            $thousands_separator = '';
            if ($params->get('thousands_separator', '0') == '0') {
                $thousands_separator = '';
            } elseif ($params->get('thousands_separator', '0') == 'space') {
                $thousands_separator = ' ';
            } elseif ($params->get('thousands_separator', '0') == 'dot') {
                $thousands_separator = '.';
            } elseif ($params->get('thousands_separator', '0') == 'comma') {
                $thousands_separator = ',';
            }
            $decimal_point = '';
            if ($params->get('decimal_point', '0') == 'dot') {
                $decimal_point = '.';
            } elseif ($params->get('decimal_point', '0') == 'comma') {
                $decimal_point = ',';
            }

            $firstOption_max = new stdClass();
            $firstOption_max->text = JText::_('PLG_EXTRAFIELDS_PRICING_SELECT_VALUE_MAX');
            $firstOption_max->value = '';
            $arr_max[] = $firstOption_max;

            if($options_max && count($options_max)){
                foreach ($options_max as $i => $max) {
                    $arr_option = new stdClass();
                    $arr_option->value = $max;

                    $_max   = number_format($max, $params -> get('decimal_digit', 2)
                        , $decimal_point, $thousands_separator);
                    $arr_option->text = $_max.$params -> get('symbol_text');

                    $arr_max[] = $arr_option;
                }
            }
            $arr_min = array();

            $firstOption_min = new stdClass();
            $firstOption_min->text = JText::_('PLG_EXTRAFIELDS_PRICING_SELECT_VALUE_MIN');
            $firstOption_min->value = '';
            $arr_min[] = $firstOption_min;

            if($options_min && count($options_min)){
                foreach ($options_min as $i => $min) {
                    $arr_option_min = new stdClass();
                    $arr_option_min->value = $min;

                    $_min   = number_format($min, $params -> get('decimal_digit', 2)
                        , $decimal_point, $thousands_separator);
                    $arr_option_min->text = $_min.$params -> get('symbol_text');
                    $arr_min[] = $arr_option_min;
                }
            }
        } else {
            $value_min = (int) $params->get('min_value', 0);
            $value_max = (int) $params->get('max_value', 0);

            $value_min = (!is_null($defaultValue) && $defaultValue
                && $defaultValue[0] >= $value_min) ? $defaultValue[0] : ((int) $params->get('min_value', 0));
            $value_max = (!is_null($defaultValue) && $defaultValue
                && $defaultValue[1] <= $value_max) ? $defaultValue[1] : ((int) $params->get('max_value', 0));
            $arr_min = '';
            $arr_max = '';
        }

        $this->setVariable('options_min', $arr_min);
        $this->setVariable('value_min', $value_min);
        $this->setVariable('value_max', $value_max);
        $this->setVariable('options_max', $arr_max);

        $html   = '';

        if ($html = $this->loadTmplFile('searchinput')) {
            return $html;
        }

        return '<input name="' . $this->getSearchName() . '" id="' . $this->getSearchId() . '" '
            . ($this->isRequired() ? ' required=""' : '') . $this->getAttribute(null, null, 'search') . '/>';
    }

    public function onSearch(&$query, &$where, $search, $forceModifyQuery = false)
    {
        if ($search === '' || empty($search)) {
            return '';
        }
        $params = $this -> params;

        $storeId = md5(__METHOD__ . "::" . $this->id);
        if (!isset(self::$cache[$storeId]) || $forceModifyQuery) {
            $query->join('LEFT', '#__tz_portfolio_plus_field_content_map AS field_values_' . $this->id
                . ' ON (c.id = field_values_' . $this->id . '.contentid AND field_values_' . $this->id
                . '.fieldsid = ' . $this->id . ')');
            self::$cache[$storeId] = true;
        }
        $db = JFactory::getDbo();

        if (is_string($search)) {
            $where[] = $this->fieldvalue_column . ' LIKE "%' . $db->escape($search, true) . '%"';
        } elseif (is_array($search) && count($search)) {
            $_where = array();

            if ($search[0] || $search[1]) {
                if (!$search[0]) {
                    $search[0] = 0;
                }
                if (!$search[1]) {
                    $search[1] = 0;
                }
                $where[] = "(CONVERT(" . $this->fieldvalue_column . ", DECIMAL(".(strlen($search[1])
                        + $params -> get('decimal_digit',2) + 2).","
                    .$params -> get('decimal_digit',2).") ) BETWEEN $search[0] AND $search[1] )";
            }

            if (!empty($_where)) {
                $where[] = '(' . implode(" AND ", $_where) . ')';
            }
        }
    }

    protected function getRegex()
    {
        $regex = $this->params->get('regex', 'none');

        if ($regex == 'none') {
            $regex = '';
        }

        if ($regex == "custom") {
            $regex = trim($this->params->get('custom_regex', ''));
        }

        if (!$regex) {
            $regex = $this->regex;
        }

        return $regex;
    }


    protected function JSValidate()
    {
        $regex = $this->getRegex();

        if (!$regex) {
            return false;
        }
        $invalid_message = JText::sprintf('COM_TZ_PORTFOLIO_PLUS_EXTRAFIELDS_FIELD_VALUE_IS_INVALID', $this->getTitle());


        $invalid_message = htmlspecialchars($invalid_message, ENT_COMPAT, 'UTF-8');
        $validate_id = $this->getId();
        $document = JFactory::getDocument();

        $script = "jQuery(document).ready(function ($) {
			$('#" . $this->getId() . "-lbl').data(\"invalid_message\",\"" . $invalid_message . "\" );
			document.formvalidator.setHandler('" . $validate_id . "',
				function (value) {
					if(value=='') {
						return true;
					}
					var regex = " . $regex . ";
					return regex.test(value);
				});
			});";

        $document->addScriptDeclaration($script);

        return true;
    }
}